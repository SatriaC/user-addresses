<?php

namespace App\Services;

use Carbon\Carbon;

class BaseService
{
    protected $env;
    protected $productionEnv = 'production';
    protected $connection = 'mysql';

    public function __construct()
    {
        $this->env = config('app.env');
    }

    public function responseMessage($message, $statusCode, $isSuccess = false, $data = [])
    {
        return response()->json(
            [
                "message" => $message,
                "success" => $isSuccess,
                "data" => $data
            ],
            $statusCode
        );
    }

    public function responseMessageDanamon($statusCode, $isSuccess = false, $correlationId = "", $errors = [])
    {
        return response()->json(
            [
                "errors" => $errors,
                "correlationId" => $correlationId,
                "timeStamp" => Carbon::now()->timezone('Asia/Jakarta'),
                "success" => $isSuccess,
            ],
            $statusCode
        );
    }
}
