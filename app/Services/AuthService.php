<?php

namespace App\Services;

use \Illuminate\Support\Facades\Auth;

class AuthService {

    public function isLoggedIn()
    {
        return !is_null($this->getUser());
    }

    public function login($credentials)
    {
        return Auth::guard()->attempt($credentials) ?? false;
    }

    public function getUser()
    {
        return Auth::guard()->user();
    }

    public function getTTL()
    {
        return Auth::guard()->factory()->getTTL() * 60;
    }
}
