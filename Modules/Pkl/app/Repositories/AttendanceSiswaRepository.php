<?php

namespace Modules\Pkl\Repositories;

use App\Models\Attendance_pkl as MainModel;
use App\Models\DudiChekInOut;
use App\Models\PklRegistration;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceSiswaRepository extends BaseRepository
{
    public function __construct(MainModel $model)
    {
        date_default_timezone_set('Asia/Jakarta');
        parent::__construct($model);
    }
    public function SaveInOut($dataToSave, $siswaId)
    {
        DB::beginTransaction(); // Mulai transaction

        $getSetting = getSiteMeta();
        $tahunPelajaran = $getSetting['kbm']['tahun_pelajaran'];
        $getRegisterPkl = PklRegistration::where('siswa_id', $siswaId)->first();
        $dudiId = $getRegisterPkl->dudi_id;
        $date = $dataToSave['tanggal']; // Tanggal contoh
        $dayNumber = Carbon::parse($date)->dayOfWeekIso;

        $getAttendanceDudi = DudiChekInOut::where('dudi_id', $dudiId)
            ->where('day_number', $dayNumber)
            ->first();
        try {
            $date = Carbon::now()->format('Y-m-d');

            $getAttendance = $this->all([
                ['siswa_id', '=', $siswaId],
                ['dudi_id', '=', $getRegisterPkl->dudi_id],
                ['tahun_pelajaran', '=', $tahunPelajaran],
                ['tanggal', '=', $date],
            ]);

            if ($getAttendance->count() == 0) {
                $dataToSave['siswa_id']     = $siswaId;
                $dataToSave['dudi_id']      = $dudiId;
                $dataToSave['periode_id']   = $getRegisterPkl->periode_id;
                $dataToSave['tahun_pelajaran']   = $tahunPelajaran;
                $dataToSave['clock_in'] = $dataToSave['tanggal'] . ' ' . $getAttendanceDudi->clock_in;
                $dataToSave['clock_in_real'] = Carbon::now();
                $res = $this->create($dataToSave);
            } else {
                $dataAttendance = $getAttendance->first();
                $attId = $dataAttendance->id;
                $dataToSave['clock_out'] = $dataToSave['tanggal'] . ' ' . $getAttendanceDudi->clock_out;
                $dataToSave['clock_out_real']   = Carbon::now();

                $clockIn = Carbon::parse($dataAttendance->clock_in_real);
                $clockOut = Carbon::parse($dataToSave['clock_out_real']);
                $duration = $clockIn->diffInMinutes($clockOut);

                $dataToSave['durasi_real']      = $duration;

                $res = $this->update($dataToSave, $attId);
            }
            $res =
                DB::commit(); // Simpan perubahan ke database

            return $res; // Kembalikan data pegawai
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua perubahan jika ada error
            throw $e;
        }
    }
}
