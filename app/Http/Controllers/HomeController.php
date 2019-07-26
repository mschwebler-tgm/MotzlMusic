<?php

namespace App\Http\Controllers;

use App\Transformer\UserTransformer;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(UserTransformer $transformer)
    {
        $user = json_encode($transformer->transform(Auth::user()));
        return view('master')->with(['user' => $user]);
    }

    public function app()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        return view('master')->with(['user' => $user]);
    }
}
