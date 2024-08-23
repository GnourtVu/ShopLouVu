<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    //
    public function index()
    {
        return view('admin.home', [
            'title' => 'Admin Page'
        ]);
    }
    public function index2()
    {
        return view('admin2.main', [
            'title' => 'Admin Page'
        ]);
    }
}
