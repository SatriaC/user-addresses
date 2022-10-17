<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $service;
    public function __construct(
        UserService $service
    )
    {
        $this->service = $service;
        $this->middleware('permission:user-add', ['only' => ['store']]);
        $this->middleware('permission:user-update', ['only' => ['update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:user-nearest', ['only' => ['findNearestLocation']]);
    }

    public function index(Request $request)
    {
        return $this->service->index($request);
    }

    public function store(UserRequest $request)
    {
        return $this->service->store($request);
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($request, $id);
    }

    public function findNearestLocation(Request $request, $id)
    {
        return $this->service->findNearestLocation($request, $id);
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
