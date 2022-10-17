<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    protected $service;
    public function __construct(
        UserService $service
    )
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->index();
    }

    public function store(UserRequest $request)
    {
        return $this->service->store($request);
    }

    public function update(UserRequest $request, $id)
    {
        return $this->service->update($request, $id);
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function destroy($id)
    {
        return $this->service->destroy($id);
    }
}
