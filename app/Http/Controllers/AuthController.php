<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Admin;
use App\Models\User;
use App\Models\Roles;
use Auth;
use Hash;
use Session;

class AuthController extends Controller
{
    public function register_auth()
    {
        return view('admin.custom_auth.register');
    }
    public function login_auth()
    {
        return view('admin.custom_auth.login_auth');
    }
    public function logout_auth()
    {
        Auth::logout();
        return redirect('/login-auth')->with('message', 'Đăng xuất authentication thành công');
    }
    public function login(Request $request)
    {
        // $data = $request->validate([
        //     'email' => ['required'],
        //     'password' => ['required'],
        // ]);

        $result = User::where('email', $request->email)->where('password', md5($request->password))->first();

        if ($result) {
            Session::put('admin_id', $result->id);
            return redirect()->route('show_dashboard');
        } else {
            return redirect()->to('login-auth');
        }
        Session::save();
        // if (Auth::attempt([
        //     "email" => $request->email,
        //     "password" => Hash::make($request->password)
        // ])) {

        //     return redirect()->route('show_dashboard');
        // } else {
        //     return redirect()->to('login-auth');
        // }
    }
    public function register_auth_dashboard(Request $request)
    {
        //$this->validation($request);
        $data = $request->all();

        $admin = new User();
        $admin->name = $data['admin_name'];
        $admin->email = $data['admin_email'];
        $admin->password = md5($data['admin_password']);
        $admin->save();
        return redirect('/login-auth')->with('message', 'Đăng ký user thành công');
    }
    public function validation($request)
    {
        return $this->validate($request, [
            'admin_name' => 'required|max:255',
            'admin_phone' => 'required|max:255',
            'admin_email' => 'required|email|max:255',
            'admin_password' => 'required|max:255',
        ]);
    }
}
