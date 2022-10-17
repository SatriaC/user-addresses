<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Services\AddressService;

class AddressController extends Controller
{
    protected $service;
    public function __construct(
        AddressService $service
    )
    {
        $this->service = $service;
        $this->middleware('permission:approve-delete', ['only' => ['deleteAddproved']]);
    }

    public function index()
    {
        return $this->service->index();
    }

    public function store(AddressRequest $request)
    {
        return $this->service->store($request);
    }

    public function update(AddressRequest $request, $id)
    {
        return $this->service->update($request, $id);
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function deleteAddproved($id)
    {
        return $this->service->deleteAddproved($id);
    }

    public function destroy($id)
    {
        return $this->service->destroy($id);
    }
}
