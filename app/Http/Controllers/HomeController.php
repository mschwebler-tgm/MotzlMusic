<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = json_encode(Auth::user());
        return view('master')->with(['user' => $user]);
    }

    public function app()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        return view('master')->with(['user' => json_encode($user)]);
    }
}
