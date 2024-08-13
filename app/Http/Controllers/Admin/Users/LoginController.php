<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('admin.users.login', ['title' => "LouVu Page"]);
    }
    public function store(Request $request)
    {
        // Sử dụng phương thức validate() từ đối tượng Request
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Tiếp tục xử lý dữ liệu đã xác thực
        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ], $request->input('remember'))) {
            Session::flash('success', 'Login successfull');
            return redirect()->route('admin');
        } else {
            //Dùng session
            Session::flash('error', 'The email or password is not correct');
            return redirect()->back()
                // ->withErrors(['The email does not match our records'])
                // ->withInput(); //giữ lại thông tin để ko phải nhập lại  
            ;
        }
    }
}
