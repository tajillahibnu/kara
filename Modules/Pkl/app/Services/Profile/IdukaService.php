<?php

namespace Modules\Pkl\Services\Profile;

use App\Models\Dudi;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Modules\Pkl\Repositories\DudiRepository;

class IdukaService
{
    protected $repository;

    public function __construct(DudiRepository $repository)
    {
        $this->repository = $repository->setModel(new Dudi());
    }

    public function getBiodata()
    {
        $biodataId = Auth::user()->biodata_id;

        $getData = $this->repository->find($biodataId);

        // Ambil data User dengan filter field tertentu
        // $user = User::where('id', Auth::id())->first();
        // Ambil User dengan relasi Role
        $user = User::with('role')->where('id', Auth::id())->first();


        // Ubah ke Collection
        $idukaData = collect(optional($getData)->toArray())->except(['password']); ; // Semua field Pegawai
        $userData = collect(optional($user)->toArray())->only(['username', 'primary_role_id']); // Filter hanya field tertentu dari User

        // Tambahkan name dari role
        $userData->put('role_name', optional($user->role)->name);

        // Gabungkan Data Pegawai dan Data User
        $result = $idukaData->merge($userData);

        // Return JSON Response
        return $result;
    }

    protected function prepareData(array $input)
    {
        foreach ($input as $fild => $value) {
            $save[$fild] = $value;
        }
        return $save;
    }

    public function save($task, array $input)
    {
        $biodataId = Auth::user()->biodata_id;
        try {
            $dataToUpdate = $this->prepareData($input);
            $response = $this->repository->updateData($dataToUpdate, $biodataId);
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            throw new Exception("Failed to update item".$e->getMessage(), 500);
        }
        return $response;
    }
}
