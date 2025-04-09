<?php

namespace Modules\Pkl\Services\Jurnal;

use App\Models\JurnalKegiatan;
use App\Services\DataTableService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Modules\Pkl\Repositories\BasePklRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class KegiatanService
{
    protected $repository;

    public function __construct(BasePklRepository $repository)
    {
        $this->repository = $repository->setModel(new JurnalKegiatan());
    }

    protected function prepareData(array $input)
    {
        foreach ($input as $fild => $value) {
            $save[$fild] = $value;
        }
        return $save;
    }

    private function getValidatorRules(string $mode = 'store')
    {
        $rules = [
            'kegiatan'         => 'required|string|max:255',
            'deskripsi'        => 'nullable|string',
            'tanggal_mulai'    => 'required|date_format:Y-m-d H:i:s|before_or_equal:now',
            // 'tanggal_mulai'    => 'required|date_format:Y-m-d H:i:s|before_or_equal:today',
            // 'tanggal_mulai'    => 'required|date|before_or_equal:today',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
            'jam_mulai'        => 'nullable|date_format:H:i',
            'jam_selesai'      => 'nullable|date_format:H:i|after_or_equal:jam_mulai',
            'catatan'          => 'nullable|string',
        ];

        if ($mode === 'store') {
            $rules['pegawai_id'] = 'required|exists:pegawais,id';
        }

        return $rules;
    }

    private function getValidatorMessages()
    {
        return [
            'pegawai_id.required' => 'Tidak mendapatkan id pegawai.',
            'pegawai_id.exists'   => 'Pegawai tidak ditemukan.',
            'kegiatan.required'   => 'Nama Kegiatan wajib diisi.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.before_or_equal' => 'Tanggal mulai tidak boleh lebih dari hari ini.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah tanggal mulai.',
        ];
    }


    public function store(array $data)
    {
        $data['pegawai_id'] = Auth::user()->biodata_id;
        // Format ulang tanggal dan jam jika dikirim sebagai string dengan jam
        if (isset($data['tanggal_mulai'])) {
            $data['tanggal_mulai'] = Carbon::createFromFormat('d-m-Y H:i', $data['tanggal_mulai'])->format('Y-m-d H:i:s');
        }

        if (isset($data['tanggal_selesai'])) {
            $data['tanggal_selesai'] = Carbon::createFromFormat('d-m-Y H:i', $data['tanggal_selesai'])->format('Y-m-d H:i:s');
        }

        $validator = Validator::make($data, $this->getValidatorRules('store'));

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $tanggalMulai = Carbon::parse($data['tanggal_mulai']);
        $tanggalSelesai = Carbon::parse($data['tanggal_selesai']);
        $validated['durasi'] = $tanggalMulai->diffInMinutes($tanggalSelesai); // hasil: 2.5 jam

        try {
            $validated = $validator->validated();
            return $this->repository->create($validated);
        } catch (Exception $e) {
            throw new Exception("Gagal menyimpan data. " . $e->getMessage(), 500);
        }
    }

    public function update($id, array $data)
    {

        try {
            if (isset($data['tanggal_mulai'])) {
                $data['tanggal_mulai'] = Carbon::createFromFormat('d-m-Y H:i', $data['tanggal_mulai'])->format('Y-m-d H:i:s');
            }
            if (isset($data['tanggal_selesai'])) {
                $data['tanggal_selesai'] = Carbon::createFromFormat('d-m-Y H:i', $data['tanggal_selesai'])->format('Y-m-d H:i:s');
            }

            $messages = $this->getValidatorMessages();
            $validator = Validator::make($data, $this->getValidatorRules('update'), $messages);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $validated = $validator->validated();

            $tanggalMulai = Carbon::parse($data['tanggal_mulai']);
            $tanggalSelesai = Carbon::parse($data['tanggal_selesai']);
            $validated['durasi'] = $tanggalMulai->diffInMinutes($tanggalSelesai); // hasil: 2.5 jam

            return $this->repository->update($validated, $id);
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException("Data ID $id tidak ditemukan.");
        } catch (Exception $e) {
            throw new Exception("Gagal mengupdate data. " . $e->getMessage(), 500);
        }
    }

    public function delete($id = null)
    {
        $response = $this->repository->delete($id);

        return [
            'message' => 'Jurnal kegiatan berhasil dihapus.',
        ];
    }

    public function table($role = null)
    {
        $query = DataTableService::draw('jurnal_kegiatans');

        if ($role === 'guru') {
            $query->where('pegawai_id', Auth::user()->biodata_id);
        }

        return $query->where('deleted_at', null)
            ->addColumn('tanggal_range', function ($detail) {
                $mulai = Carbon::parse($detail->tanggal_mulai);
                $selesai = Carbon::parse($detail->tanggal_selesai);

                if ($mulai->equalTo($selesai)) {
                    return $mulai->format('d M Y');
                } else {
                    return $mulai->format('d M Y') . ' - ' . $selesai->format('d M Y');
                }
            })
            ->addColumn('jam', function ($detail) {
                $mulai = Carbon::parse($detail->tanggal_mulai);
                $selesai = Carbon::parse($detail->tanggal_selesai);

                $jamMulai = $mulai->format('H:i') . ' WIB';
                $jamSelesai = $selesai->format('H:i') . ' WIB';

                if ($mulai->toDateString() === $selesai->toDateString()) {
                    // Tanggal sama, tampilkan jam saja
                    return $jamMulai . ' - ' . $jamSelesai;
                } else {
                    // Tanggal beda, tambahkan tanggal selesai
                    return $jamMulai . ' - ' . $jamSelesai . ' (' . $selesai->format('d M') . ')';
                }
            })
            ->addColumn('deskripsi', function ($detail) {
                $deskripsi = strip_tags($detail->deskripsi); // hilangkan tag HTML kalau ada
                $limit = 100;

                if (strlen($deskripsi) > $limit) {
                    $short = substr($deskripsi, 0, $limit) . '...';
                    return "<div class='column-deskripsi'>
                                <span class='short-text'>{$short}</span>
                                <span class='full-text d-none'>{$deskripsi}</span>
                                <span class='read-more' onclick='toggleReadMore(this)'>Read more</span>
                            </div>";
                } else {
                    return "<div class='column-deskripsi'>{$deskripsi}</div>";
                }
            })
            ->addColumn('action', function ($detail) {
                $btnMore = '';
                $btnview = '';
                $btnview .= '<a class="btn btn-icon" href="javascript:void(0);" data-permision="user-update" onclick="onDetails(this)" data-params="' . base64_encode(json_encode($detail)) . '">
                                <i class="ti ti-eye ti-md"></i>
                            </a>';
                $btnMore .= '<a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="editData(this)" data-params="' . base64_encode(json_encode($detail)) . '">Edit</a>';
                $btnMore .= '<div class="dropdown-divider"></div>';
                $btnMore .= '<a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="deleteData(this)" data-params="' . base64_encode(json_encode($detail)) . '">Delete</a>';

                $btnDropdown = $btnMore === '' ? '' : '
                        <div class="dropdown">
                            <a href="javascript:;" class="btn dropdown-toggle hide-arrow btn-icon p-0" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical ti-md"></i></a>
                            <div class="dropdown-menu dropdown-menu-end">
                                ' . $btnMore . '
                            </div>
                        </div>
                ';

                return '
                    <div class="d-flex align-items-center">
                        ' . $btnview . '
                        ' . $btnDropdown . '
                    </div>
                    ';
            })
            ->rawColumns(['deskripsi', 'action'])
            ->toJson();
    }
}
