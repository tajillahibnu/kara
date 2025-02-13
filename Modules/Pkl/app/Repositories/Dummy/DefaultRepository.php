<?php

namespace Modules\Pkl\Repositories\Dummy;

use App\Models\User as MainModel;
use App\Repositories\BaseRepository;

class DefaultRepository extends BaseRepository
{
    public function __construct(MainModel $model)
    {
        parent::__construct($model);
    }


    /**
     * Sample Contoh pengunaan jika ingin langsung digunakan seperti base
     */
    // protected $defaultModel = Dudi::class;

    // public function __construct()
    // {
    //     // Set default model jika belum diatur
    //     if (!$this->model) {
    //         $this->setModel(new $this->defaultModel());
    //     }
    // }

    /**
     * Rekomendasi jika langsung ingin mengunakan model pada service
     */
    // public function __construct()
    // {
    //     // Kosongkan, model diatur melalui metode setModel.
    // }

}