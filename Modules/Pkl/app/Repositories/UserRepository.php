<?php

namespace Modules\Pkl\Repositories;

use App\Repositories\BaseRepository;
use App\Models\User as MainModel;

class UserRepository extends BaseRepository
{
    public function __construct(MainModel $model)
    {
        parent::__construct($model);
    }
}