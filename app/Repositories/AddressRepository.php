<?php

namespace App\Repositories;

use App\Models\Address;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class AddressRepository extends BaseRepository
{
    public function __construct(Address $model)
    {
        $this->model = $model;
    }

    public function getByDefaultIs1()
    {
        $data = $this->model
        ->where('user_id', Auth::guard('api')->user()->id)
        ->where('is_default', 1)->get()->first();

        return $data;
    }
}
