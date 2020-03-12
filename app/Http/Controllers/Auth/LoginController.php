<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\UserSocialAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
      _log( Auth::user()->id, 'Inicio de sesión', 'User\Login', $request );
      $user->update([
          'last_login_at' => now(),
          'last_login_ip' => $request->getClientIp()
      ]);
    }

    public function logout(Request $request)
    {
      _log(Auth::user()->id, 'Cierre de sesión', 'User\Logout', $request );
      auth()->logout();
      session()->flush();
      return redirect('/login');
    }

    public function redirectToProvider ($driver)
    {
      return Socialite::driver($driver)->redirect();
    }

    public function handleProviderCallback (Request $request, $driver)
    {
      if( ! request()->has('code') || request()->has('denied'))
      {
        session()->flash('message', ['danger', __("Inicio de sesión cancelado")]);
        return redirect('login');
      }
      else
      {
        $socialUser = Socialite::driver($driver)->user();
        $user = null;
        $success = true;
        $email = $socialUser->email;
        $check = User::whereEmail($email)->first();

        if( $check )
        {
          $user = $check;
          $filtro= UserSocialAccount::where('user_id',$user->id)->count();
          
          if ( $filtro <= 0 )
          {
            UserSocialAccount::create([
              "user_id"       => $user->id,
              "provider"      => $driver,
              "provider_uid"  => $socialUser->id
            ]);
          }
        }
        else
        {
          return redirect('login');
        }

        if($success === true)
        {
          \DB::commit();
          auth()->loginUsingId($user->id);
          return redirect(route('home'));
        }
      }
    }
}
