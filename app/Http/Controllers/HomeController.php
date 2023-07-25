<?php

namespace App\Http\Controllers;

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
    public function userHome()
    {
        return view('home',['msg'=>"hello, i am User"]);
    }
    public function supplierHome()
    {
        return view('home',['msg'=>"hello, i am Supplier"]);
    }
    public function adminHome()
    {
        return view('home',['msg'=>"hello, i am Admin"]);
    }
}
