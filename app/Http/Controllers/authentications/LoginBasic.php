<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginBasic extends Controller
{
  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required|string',
    ]);

    $credentials = $request->only('email', 'password');
    $remember = $request->filled('remember');
    if (Auth::guard('admin')->attempt($credentials, $remember)) {
      $user = Auth::user();
      $token = $user->createToken("API_ACCESS_TOKEN")->accessToken;
      $user->api_token = $token;
      $user->save();
      return redirect()->intended('/')->with("success", "خوش اومدی ".$user->name." !");
    }
    return redirect()->back()->withInput($request->only('email', 'remember'))->with("error", "نام کاربری یا رمز عبور صحیح نمی‌باشد");
  }

  public function logout()
  {
    Auth::guard('admin')->logout();

    return redirect('/auth/login');
  }
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
  }
}