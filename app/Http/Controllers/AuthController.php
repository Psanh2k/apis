<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginAction(LoginRequest $request)
    {
        return resolve(AuthService::class)->handle($request);
    }
}
