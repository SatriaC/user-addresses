<?php

namespace App\Services;

use App\Models\Employees\Employee;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Str;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class AuthService extends BaseService
{
    protected $repo;
    public function __construct(
        UserRepository $repo
    ) {
        parent::__construct();
        $this->repo = $repo;
    }

    public function login($request)
    {
        try {
            $item = $this->repo->getByEmail($request);
            if (!isset($item)) {
                return $this->responseMessage(__('content.message.login.email_not_registered'), 400, false);
            }
            if (!Auth::attempt(['email' => $item->email, 'password' => $request->password])) {
                return $this->responseMessage(__('content.message.login.credential_not_match'), 400, false);
            }

            $user = Auth::user();
            $data['access_token'] = $user->createToken('nApp')->accessToken;

            return $this->responseMessage(__('content.message.login.success'), 200, true, $data);
        } catch (Exception $exc) {
            Log::error($exc);
            return $this->responseMessage(__('content.message.login.failed'), 400, false);
        }
    }
}
