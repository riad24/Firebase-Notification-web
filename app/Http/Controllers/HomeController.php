<?php

namespace App\Http\Controllers;

use App\PostNotifaction;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = PostNotifaction::all();
        $users = User::all();

        return view('home',compact('posts','users'));
    }
}
