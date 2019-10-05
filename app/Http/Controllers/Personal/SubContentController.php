<?php

namespace App\Http\Controllers\Personal;

use App\Daos\UserDao;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubContentController extends Controller
{
    public function updateSubContent(Request $request, UserDao $userDao)
    {
        $userDao->updateSubContent($request->get('subContent'));
    }

    public function availableContent()
    {
        return config('sub-content.available-content');
    }
}
