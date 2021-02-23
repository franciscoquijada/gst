<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\UserSocialAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
      $this->middleware('guest')->except('logout');
      session()->put('predeterminado', 1);
    }

    public function authenticated(Request $request, $user)
    {
      _log( Auth::user(), 'Inicio de sesión', 'User\Login', $request );
      $user->update([
          'last_login_at' => now(),
          'last_login_ip' => $request->getClientIp()
      ]);
    }

    public function logout(Request $request)
    {
      _log( Auth::user(), 'Cierre de sesión', 'User\Logout', $request );
      auth()->logout();
      session()->flush();
      return redirect( '/login' );
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    public function redirectTo()
    {
        return redirect()->route('home');
    }
}
