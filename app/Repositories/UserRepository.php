<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getByEmail($request)
    {
        $data = $this->model->where('email', $request->email)->first();

        return $data;
    }
}
