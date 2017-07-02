<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\DB\Admin;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('Admin::dashboardIndex');
        }

        $loginAlert = $request->session()->get('loginAlert');

        return view('admin/login/login', [
            'alertInfo' => $loginAlert
        ]);
    }

    public function doLogin(Request $request)
    {
        $remeber = $request->rememberMe ? true : false;
        $email = $request->email;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $request->session()->flash('loginAlert', 'Email格式不正确');
            return redirect()->route('Admin::login');
        }

        $adminInfo = Admin::where('email', $email)->first();
        if (empty($adminInfo)) {
            $request->session()->flash('loginAlert', '用户不存在');
            return redirect()->route('Admin::login');
        }

        $password = $request->password . $adminInfo->salt;
        // this is password generate method
        // $password = Hash::make($request->password . $adminInfo->salt);

        if (Auth::attempt(['email' => $email, 'password' => $password], $remeber)) {
            return redirect()->route('Admin::dashboardIndex');
        } else {
            $request->session()->flash('loginAlert', '密码错误');
            return redirect()->route('Admin::login');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('Admin::login');
    }
}
