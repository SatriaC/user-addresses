<?php

namespace App\Services;

use App\Repositories\AddressRepository;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddressService extends BaseService
{
    protected $repo;

    public function __construct(
        AddressRepository $repo
    ) {
        parent::__construct();
        $this->repo = $repo;
    }

    public function index()
    {
        try {
            $data = $this->repo->all();

            return $this->responseMessage(__('content.message.read.success'), 200, true, $data);
        } catch (Exception $exc) {
            Log::error($exc);
            return $this->responseMessage(__('content.message.read.failed'), 400, false);
        }
    }

    public function store($request)
    {
        $db = DB::connection($this->connection);
        $db->beginTransaction();
        try {
            $data = $request->all();
            $data['user_id'] = Auth::guard('api')->user()->id;
            $item = $this->repo->create($data);
            $db->commit();

            return $this->responseMessage(__('content.message.create.success'), 200, true, $item);
        } catch (Exception $exc) {
            Log::error($exc);
            $db->rollback();
            return $this->responseMessage(__('content.message.create.failed'), 400, false);
        }
    }

    public function update($request, $id)
    {
        $db = DB::connection($this->connection);
        $db->beginTransaction();
        try {
            $data = $request->all();
            $this->repo->update($data, $id);
            $db->commit();

            $item = $this->repo->getById($id);

            return $this->responseMessage(__('content.message.update.success'), 200, true, $item);
        } catch (Exception $exc) {
            Log::error($exc);
            $db->rollback();
            return $this->responseMessage(__('content.message.update.failed'), 400, false);
        }
    }

    public function setDefault($id)
    {
        $db = DB::connection($this->connection);
        $db->beginTransaction();
        try {
            $getDefault = $this->repo->getByDefaultIs1();
            if (isset($getDefault)) {
                $dataLastDefault['is_default'] = 0;
                $this->repo->update($dataLastDefault, $getDefault->id);
            }
            $data['is_default'] = 1;
            $this->repo->update($data, $id);
            $db->commit();

            $item = $this->repo->getById($id);

            return $this->responseMessage(__('content.message.update.success'), 200, true, $item);
        } catch (Exception $exc) {
            Log::error($exc);
            $db->rollback();
            return $this->responseMessage(__('content.message.update.failed'), 400, false);
        }
    }

    public function deleteApproved($id)
    {
        $db = DB::connection($this->connection);
        $db->beginTransaction();
        try {
            $address = $this->repo->getById($id);
            $data['is_approved'] = $address->is_approved == 0 ? 1 : 0;
            $this->repo->update($data, $id);
            $db->commit();

            $item = $this->repo->getById($id);

            return $this->responseMessage(__('content.message.update.success'), 200, true, $item);
        } catch (Exception $exc) {
            Log::error($exc);
            $db->rollback();
            return $this->responseMessage(__('content.message.update.failed'), 400, false);
        }
    }

    public function show($id)
    {
        try {
            $data = $this->repo->getById($id);

            return $this->responseMessage(__('content.message.read.success'), 200, true, $data);
        } catch (Exception $exc) {
            Log::error($exc);
            return $this->responseMessage(__('content.message.read.failed'), 400, false);
        }
    }

    public function destroy($id)
    {
        try {
            $item = $this->repo->getById($id);
            if ($item->is_approved == 0) {
                // @TODO make notification to admin
                return $this->responseMessage(__('content.message.approval.waiting'), 200, true);
            }
            $this->repo->delete($id);
            return $this->responseMessage(__('content.message.delete.success'), 200, true);
        } catch (\Throwable $exc) {
            Log::error($exc);
            return $this->responseMessage(__('content.message.delete.failed'), 400, false);
        }
    }
}
