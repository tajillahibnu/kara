<?php

namespace Modules\Pkl\Repositories;

use App\Models\Dudi as MainModel;
use App\Repositories\BaseRepository;

class DudiRepository extends BaseRepository
{
    public function __construct(MainModel $model)
    {
        parent::__construct($model);
    }
}
