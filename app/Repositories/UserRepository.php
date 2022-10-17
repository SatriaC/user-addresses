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

    public function getAll($request)
    {
        $data = $this->model;

        if (isset($request->email)) {
            $data = $data->where('users.email', 'LIKE', '%' . $request->email . '%');
        }

        return $data->get();
    }

    public function getByEmail($request)
    {
        $data = $this->model->where('email', $request->email)->first();

        return $data;
    }
}
