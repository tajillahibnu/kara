<?php

namespace Modules\Pkl\Services\Pkl;

use App\Services\DataTableService;

class PesertaPklService
{
    /**
     * Menampilkan data dalam bentuk DataTable.
     *
     * @return mixed Data dalam format JSON untuk DataTable.
     */
    public function table()
    {
        return DataTableService::draw('pkl_registrations')
            ->select(['pkl_registrations.*', 'siswas.name', 'siswas.nis', 'siswas.rombel_name', 'siswas.jurusan_id'])
            ->join('siswas', [
                ['siswas.id', '=', 'pkl_registrations.siswa_id'],
            ])
            ->where('status_register', 'completed')
            ->where('status_pelaksana', 'completed')
            ->where('deleted_at', null)
            ->addColumn('dudi_name', function ($detail) {
                return '-';
            })
            ->addColumn('status', function ($detail) {
                return '-';
            })
            ->addColumn('action', function ($detail) {
                return '
                <div class="d-inline-block">
                    <a href="app-invoice-preview.html" data-bs-toggle="tooltip" class="btn btn-icon" data-bs-placement="top" aria-label="Preview Invoice" data-bs-original-title="Preview Invoice"><i class="icon-base ti tabler-eye icon-md"></i></a>
                    <a href="javascript:void(0);" class="btn btn-sm rounded-pill btn-icon dropdown-toggle hide-arrow show" data-bs-toggle="dropdown" aria-expanded="true"><i class="ti ti-dots-vertical ti-md"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end m-0" data-popper-placement="bottom-end">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="onDudi(this)" data-params="' . base64_encode(json_encode($detail)) . '">Edit</a>
                        </li>
                        <div class="dropdown-divider"></div>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" data-permision="user-update" onclick="onDetails(this)" data-params="' . base64_encode(json_encode($detail)) . '">Details</a>
                        </li>
                    </ul>
                </div>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
    }
}
