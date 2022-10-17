<?php

namespace App\Repositories;

use App\Models\Address;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressRepository extends BaseRepository
{
    public function __construct(Address $model)
    {
        $this->model = $model;
    }

    public function getAll($request)
    {
        $data = $this->model;
        if (isset($request->user_id)) {
            $data = $data->where('user_id', $request->user_id);
        }

        return $data->get();
    }

    public function getByDefaultIs1()
    {
        $data = $this->model
            ->where('user_id', Auth::guard('api')->user()->id)
            ->where('is_default', 1)->get()->first();

        return $data;
    }

    public function findNearestLocation($request, $user)
    {
        $data =  $this->model
            ->leftJoin('users as tb1', 'tb1.id', '=', 'addresses.user_id')
            ->select(DB::raw("addresses.id, addresses.name, addresses.address, addresses.latitude, addresses.longitude, addresses.user_id, tb1.name as user_name, ( 6371 * acos( cos( radians('$user->default_address_latitude') ) * cos( radians( addresses.latitude ) ) * cos( radians( addresses.longitude ) - radians('$user->default_address_longitude') ) + sin( radians('$user->default_address_latitude') ) * sin( radians( addresses.latitude ) ) ) ) AS distance"))->orderBy('distance');

        if (isset($request->km)) {
            $data = $data->havingRaw('distance < ' . $request->km);
        }

        return $data->get();
    }
}
