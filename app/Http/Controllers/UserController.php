<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('front.user_about');
    }

    public function conversations()
    {
        return view('front.user_conversations');
    }

    public function following()
    {
        return view('front.user_following');
    }
}
