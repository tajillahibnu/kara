<?php

namespace Modules\Pkl\Repositories;

use App\Repositories\BaseRepository;
use App\Models\ConfigApp as MainModel;

class ConfigAppRepository extends BaseRepository
{
    public function __construct(MainModel $model)
    {
        parent::__construct($model);
    }
}