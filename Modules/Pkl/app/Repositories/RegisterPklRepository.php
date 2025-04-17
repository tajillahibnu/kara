<?php

namespace Modules\Pkl\Repositories;

use App\Models\Jurusan;
use App\Models\PklApproval;
use App\Models\PklPeriode;
use App\Models\PklRegistration;
use App\Models\PklRegistrationStatuses;
use App\Models\Siswa;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterPklRepository extends BaseRepository
{
    public function __construct(PklRegistration $model)
    {
        parent::__construct($model);
    }

    public function register(array $save, int $id)
    {
        $getSetting = getSiteMeta();
        $tahunPelajaran = $getSetting['kbm']['tahun_pelajaran'];
        $getSiswa = Siswa::with('jurusans')->find($id);

        return DB::transaction(function () use ($save, $id, $tahunPelajaran, $getSiswa) {
            // 1. Update data siswa
            $siswa = Siswa::find($id);
            if ($siswa) {
                $siswa->update(['is_pkl' => true]);
            } else {
                throw new \Exception("Siswa tidak ditemukan.");
            }

            // 2. Lengkapi data untuk create PKL Registration
            $save['jurusan_id'] = $siswa->jurusan_id;
            $save['jurusan_name'] = $getSiswa->jurusans->name ?? '-';
            $save['tingkat_id'] = $siswa->tingkat_id;
            $save['kelas'] = $siswa->rombel_name;
            $save['tahun_pelajaran'] = $tahunPelajaran;

            // 3. Ambil data periode PKL
            $getPriode = PklPeriode::find($save['periode_id']);
            if (!$getPriode) {
                throw new \Exception("Periode PKL tidak ditemukan.");
            }

            $save['tanggal_mulai'] = $getPriode->tanggal_mulai;
            $save['tanggal_berakhir'] = $getPriode->tanggal_selesai;

            // 4. Buat data pendaftaran PKL
            $pklRegistration = PklRegistration::create($save);

            if (!$pklRegistration) {
                throw new \Exception("Gagal menyimpan data pendaftaran PKL.");
            }

            if($pklRegistration->status_register === 'completed'){
                // Kirim Notif siswa atau email telah tergis pkl
            }else{
                // 5. Ambil approvals sesuai tipe pendaftaran
                $approvals = PklApproval::where('approval_type', $pklRegistration->registration_type)
                    ->orderBy('approval_order', 'asc')
                    ->get();
    
                if ($approvals->isEmpty()) {
                    throw new \Exception("Approval belum dikonfigurasi.");
                }
    
                // 6. Simpan ke tabel pkl_registration_statuses
                foreach ($approvals as $approval) {
                    $status = new PklRegistrationStatuses([
                        'siswa_id' => $id,
                        'jurusan_id' => $pklRegistration->jurusan_id,
                        'registration_id' => $pklRegistration->id,
                        'role_id' => $approval->role_id,
                        'status' => 'pending',
                        'approval_order' => $approval->approval_order,
                        'is_view' => $approval->approval_order == 1,
                    ]);
    
                    if (!$status->save()) {
                        throw new \Exception("Gagal menyimpan status approval.");
                    }
                }
            }



            return $pklRegistration;
        });
    }


    public function combosiswa($data, $select = "CONCAT('[', nis, '] ', name) as name,nis ,id")
    {
        $query = Siswa::selectRaw($select)
            ->where('is_pkl', false)
            ->where('is_active', true)
            ->whereNotNull('rombel_id');

        if (!empty($data['tingkat_id'])) {
            $query->where('tingkat_id', $data['tingkat_id']);
        }

        if (!empty($data['jurusan_id'])) {
            $query->where('jurusan_id', $data['jurusan_id']);
        } else {
            $jurusanId = $this->jurusanId();
            $query->where('jurusan_id', $jurusanId);
        }
        return $query->get();
    }

    public function jurusanId(){
        return Jurusan::where('kakomli_id', Auth::user()->biodata_id)->value('id');
    }
}
