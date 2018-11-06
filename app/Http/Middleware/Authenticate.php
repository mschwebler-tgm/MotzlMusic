<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        return route('login');
    }

    protected function authenticate($request, array $guards)
    {
        $userToken = unserialize(Cookie::get('remember'));
        if ($userToken) {
            list($password, $email) = explode(':', $userToken);
            $credentials = compact(['password', 'email']);

            if (!Auth::attempt($credentials)) {
                parent::authenticate($request, $guards);
            }
        } else {
            parent::authenticate($request, $guards);
        }
    }
}
