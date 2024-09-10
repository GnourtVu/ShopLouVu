<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Customer;
use Illuminate\Http\Request;

class MainController extends Controller
{
    //
    public function index()
    {
        return view('admin.home', [
            'title' => 'Dashbroad',
            'countOd' => Cart::count(),
            'countCt' => Customer::count(),

        ]);
    }
}
