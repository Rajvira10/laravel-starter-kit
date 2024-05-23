<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            $skip_routes = ['login', 'authenticate', 'forgot_password', 'reset_password', 'reset_password_form', 'reset_password_update', 'logout', 'dashboard'];

            if(!auth()->check() || in_array($request->route()->getName(), $skip_routes)) {
                return $next($request);
            }
            if (!auth()->user()->hasPermission($request->route()->getName())) {
                return redirect()->route('dashboard')->with('error', 'You do not have permission to view this page.');
            }
            return $next($request);
        });
    }

}
