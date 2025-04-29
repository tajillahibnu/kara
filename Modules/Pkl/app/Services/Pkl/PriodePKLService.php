<?php

namespace Modules\Pkl\Services\Pkl;

use App\Models\Jurusan;
use App\Models\PklPeriode;
use App\Services\DataTableService;
use Exception;
use Illuminate\Support\Facades\Log;
use Modules\Pkl\Repositories\PriodePKLRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PriodePKLService
{
    // Properti untuk menyimpan instance repository yang digunakan
    protected $repository;
    public function __construct(PriodePKLRepository $repository)
    {
        /**
         * Constructor ini digunakan jika developer ingin memanfaatkan repository generik
         * dengan model yang dapat diubah-ubah sesuai kebutuhan.
         * Contoh: Repository dapat digunakan untuk berbagai model selain User.
         * Keunggulan: Fleksibilitas tinggi, mempermudah penggunaan ulang kode.
         * Kekurangan: Membutuhkan penyesuaian model secara manual setiap kali diperlukan.
         */
        $this->repository = $repository->setModel(new PklPeriode());
    }

    /**
     * Menyiapkan data sebelum disimpan ke dalam database.
     *
     * @param array $input Data masukan dari user.
     * @return array Data yang sudah diproses dan siap disimpan.
     */
    protected function prepareData(array $input)
    {
        return [
            'name'                  => $input['name'] ?? null,
            'tahun_ajaran'          => $input['tahun_ajaran'] ?? null,
            'kuota_siswa'           => $input['kuota_siswa'] ?? null,
            'batas_registrasi'      => date('Y-m-d', strtotime($input['batas_registrasi'])) ?? null,
            'tanggal_mulai'         => date('Y-m-d', strtotime($input['tanggal_mulai'])) ?? null,
            'tanggal_selesai'       => date('Y-m-d', strtotime($input['tanggal_selesai'])) ?? null,
            'syarat_pendaftaran'    => $input['syarat_pendaftaran'] ?? null,
        ];
    }

    /**
     * Menyimpan data baru ke dalam database.
     *
     * @param array $input Data masukan dari user.
     * @return array Respons hasil penyimpanan.
     */
    public function store(array $input)
    {
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            $dataToSave = $this->prepareData($input);
            $response = $this->repository->create($dataToSave);
            $response['data'] = $input;
        } catch (Exception $e) {
            $response['statusCode'] = 400;
            $response['message'] = $e->getMessage();
        }
        return $response;
    }

    /**
     * Memperbarui data yang sudah ada di database.
     *
     * @param int $id ID data yang akan diperbarui.
     * @param array $input Data masukan dari user.
     * @return array Respons hasil pembaruan.
     * @throws NotFoundHttpException Jika data tidak ditemukan.
     * @throws Exception Jika terjadi kesalahan lain.
     */
    public function update($id, array $input)
    {
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            $dataToUpdate = $this->prepareData($input);
            $dataToUpdate['tingkatan'] = json_encode($input['tingkatan']);
            $response['data'] = $this->repository->update($dataToUpdate, $id);
        } catch (NotFoundHttpException $e) {
            $response['message'] = "Item with ID $id not found for update";
            throw new NotFoundHttpException($response['message']);
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            Log::error("Error updating : " . $response['message']);
            throw new Exception("Failed to update item " . $response['message'], 500);
        }
        return $response;
    }

    public function status($id, array $input)
    {
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            $dataToUpdate['is_active'] = !$input['is_active'] ?? true;
            // print_r($dataToUpdate);
            // exit;
            $response['data'] = $this->repository->update($dataToUpdate, $id);
        } catch (NotFoundHttpException $e) {
            $response['message'] = "Item with ID $id not found for update";
            throw new NotFoundHttpException($response['message']);
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            Log::error("Error updating : " . $response['message']);
            throw new Exception("Failed to update item " . $response['message'], 500);
        }
        return $response;
    }

    /**
     * Menghapus data dari database.
     *
     * @param int|null $id ID data yang akan dihapus.
     * @return array Respons hasil penghapusan.
     * @throws NotFoundHttpException Jika data tidak ditemukan.
     * @throws Exception Jika terjadi kesalahan lain.
     */
    public function delete($id = null)
    {
        $response['statusCode'] = 200;
        try {
            $response = $this->repository->delete($id);
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException("Item with ID $id not found for deletion");
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            Log::error("Error deleting item: " . $e->getMessage());
            throw new Exception("Failed to delete item" . $e->getMessage(), 500);
        }
    }

    /**
     * Menampilkan data dalam bentuk DataTable.
     *
     * @return mixed Data dalam format JSON untuk DataTable.
     */
    public function table()
    {
        return DataTableService::draw('pkl_periodes')
            ->where('deleted_at', null)
            ->addColumn('syarat_tingkat', function ($detail) {
                $raw = $detail->tingkatan;

                // Coba decode dua kali jika encode-nya double
                $tt = json_decode($raw, true);

                // Jika decode pertama malah jadi string lagi, decode ulang
                if (is_string($tt)) {
                    $tt = json_decode($tt, true);
                }

                // Sekarang pastikan array valid
                if (!is_array($tt) || empty($tt)) {
                    return 'Tidak ada syarat tingkat';
                }

                // Ambil data tingkat dari DB
                $getTingkat = \App\Models\Tingkat::whereIn('romawi', $tt)->pluck('romawi')->toArray();
                return 'Kelas: ' . implode(', ', $getTingkat);
            })
            ->addColumn('status', function ($detail) {
                $badgeText = $detail->is_active ? 'checked' : '';
                return '
                        <div class="w-75 d-flex justify-content-end">
                            <div class="form-check form-switch me-n3">
                            <input type="checkbox" class="form-check-input" name="' . $detail->id . '" data-params="' . base64_encode(json_encode($detail)) . '" onchange="setActive(this)" ' . $badgeText . '>
                            </div>
                        </div>
                ';
            })
            ->addColumn('action', function ($detail) {
                $btnMore = '';
                $btnview = '';
                $btnview .= '<a class="btn btn-icon" href="javascript:void(0);" data-permision="user-update" onclick="onDetails(this)" data-params="' . base64_encode(json_encode($detail)) . '">
                                <i class="ti ti-eye ti-md"></i>
                            </a>';
                $btnMore .= '<a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="editData(this)" data-params="' . base64_encode(json_encode($detail)) . '">Edit</a>';
                $btnMore .= '<a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="deleteData(this)" data-params="' . base64_encode(json_encode($detail)) . '">Delete</a>';
                $btnMore .= '<div class="dropdown-divider"></div>';
                $btnMore .= '<a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="onViewKompt(this)" data-params="' . base64_encode(json_encode($detail)) . '">Daftar Jurusan</a>';
                $btnMore .= '<a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="onPageInduka(this)" data-params="' . base64_encode(json_encode($detail)) . '">Daftar Induka</a>';

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
            ->rawColumns(['syarat_tingkat', 'status', 'action'])
            ->toJson();
    }

    public function tableJurusanPriode($request)
    {
        $query = DataTableService::draw('jurusan_priode_pkls');
        $query->select(['jurusan_priode_pkls.id', 'jurusans.name AS jurusan_name']);
        $query->join('jurusans', [
            ['jurusans.id', '=', 'jurusan_priode_pkls.jurusan_id'],
        ]);

        $query->where('periode_id', $request['priode']);
        return $query->where('jurusan_priode_pkls.deleted_at', null)
            ->addColumn('action', function ($detail) {
                $btnMore = '';
                $btnview = '';
                $btnview .= '<a class="btn btn-icon" href="javascript:void(0);" data-permision="user-update" onclick="onDeleteKompt(this)" data-params="' . base64_encode(json_encode($detail)) . '">
                                <i class="ti ti-trash ti-md"></i>
                            </a>';

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
            ->rawColumns(['syarat_tingkat', 'status', 'action'])
            ->toJson();
    }

    public function combokompt($request)
    {

        if (!empty($request['tipe'])) {
            $data = $this->repository->fetchPriodeKompt($request['id']);
        } else {
            $data = $this->repository->fetchKompt();
        }

        return $data->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => '[' . ucwords($item->kode) . '] ' . ucwords($item->name),
                'kode' => $item->kode,
            ];
        });
    }

    public function comboInduka($request)
    {
        if (!empty($request['tipe'])) {
            $data = $this->repository->fetchPriodeKompt($request['id']);
        } else {
            $data = $this->repository->fetchInduka();
        }

        return $data->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => ucwords($item->name),
            ];
        });
    }

    public function add_induka($input)
    {
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            foreach ($input['select_induka'] as $key => $dudi_id) {
                $save['priode_id'] = $input['priode_id'];
                $save['jurusan_id'] = $input['jurusan'];
                $save['dudi_id'] = $dudi_id;
                $response[] = $this->repository->indukaToPriode($save);
            }
        } catch (Exception $e) {
            $response['statusCode'] = 400;
            $response['message'] = $e->getMessage();
        }
        return $response;
    }

    public function deleteInduka($id = null)
    {
        $response['statusCode'] = 200;
        try {
            $query = \App\Models\PklPriodeInduka::find($id);

            if (!$query) {
                return [
                    'success' => false,
                    'message' => 'Data tidak ditemukan.'
                ];
            }

            $query->delete();
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException("Item with ID $id not found for deletion");
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            Log::error("Error deleting item: " . $e->getMessage());
            throw new Exception("Failed to delete item" . $e->getMessage(), 500);
        }
    }


    public function add_kompt($input)
    {
        $response['success'] = false;
        $response['statusCode'] = 200;
        try {
            foreach ($input['select_kompt'] as $key => $jurusan_id) {
                $save['periode_id'] = $input['priode_id'];
                $save['jurusan_id'] = $jurusan_id;
                $response[] = $this->repository->jurusanToPriode($save);
            }
        } catch (Exception $e) {
            $response['statusCode'] = 400;
            $response['message'] = $e->getMessage();
        }
        return $response;
    }

    public function deleteKompt($id = null)
    {
        $response['statusCode'] = 200;
        try {
            $query = \App\Models\JurusanPriodePkl::find($id);

            if (!$query) {
                return [
                    'success' => false,
                    'message' => 'Data tidak ditemukan.'
                ];
            }

            $query->delete();
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException("Item with ID $id not found for deletion");
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            Log::error("Error deleting item: " . $e->getMessage());
            throw new Exception("Failed to delete item" . $e->getMessage(), 500);
        }
    }

    public function tablePriodeInduka($request)
    {
        $query = DataTableService::draw('pkl_priode_indukas');
        $query->select([
            'pkl_priode_indukas.id',
            'pkl_priode_indukas.kuota AS jumlah_kuota',
            'jurusans.name AS jurusan_name',
            'dudis.name AS dudi_name'
        ]);
        $query->join('jurusans', [
            ['jurusans.id', '=', 'pkl_priode_indukas.jurusan_id'],
        ]);
        $query->join('dudis', [
            ['dudis.id', '=', 'pkl_priode_indukas.dudi_id'],
        ]);

        $query->where('pkl_priode_indukas.jurusan_id', $request['jurusan']);
        $query->where('pkl_priode_indukas.priode_id', $request['priode']);
        return $query->where('pkl_priode_indukas.deleted_at', null)
            ->addColumn('action', function ($detail) {
                $btnMore = '';
                $btnview = '';
                $btnview .= '<a class="btn btn-icon" href="javascript:void(0);" data-permision="user-update" onclick="onDeleteInduka(this)" data-params="' . base64_encode(json_encode($detail)) . '">
                                <i class="ti ti-trash ti-md"></i>
                            </a>';

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
            ->rawColumns(['syarat_tingkat', 'status', 'action'])
            ->toJson();
    }
}
