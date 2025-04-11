<?php

namespace Modules\Pkl\Repositories;

use App\Models\Jurusan;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class BasePklRepository extends BaseRepository
{
    public function __construct()
    {
        // Kosongkan, model diatur melalui metode setModel.
    }

    public function jurusanId(){
        return Jurusan::where('kakomli_id', Auth::user()->biodata_id)->value('id');
    }
}
