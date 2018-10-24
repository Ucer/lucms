<?php

namespace App\Http\Controllers;


class IndexController extends WebController
{

    public function __construct()
    {
    }

    public function index()
    {
        return view('welcome');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function docs()
    {
        return view('docs');
    }
}
