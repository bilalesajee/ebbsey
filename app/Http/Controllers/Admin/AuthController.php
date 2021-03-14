<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller {

    function loginView() {
        if (Auth::guard('admin')->check()) {
            return redirect('admin_dashboard');
        } else {
            $data['title'] = 'Admin Login';
            return view('admin/login', $data);
        }
    }

    function login(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $auth = auth()->guard('admin');
        if ($auth->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            return redirect('admin_dashboard');
        } else {
            Session::flash('error', 'Invalid email or password.');
            return Redirect::to(URL::previous());
        }
    }

}
