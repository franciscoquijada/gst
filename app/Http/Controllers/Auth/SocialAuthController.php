<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\UserSocialAccount;

use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
	public function redirectToProvider ($driver)
  {
    return Socialite::driver($driver)->redirect();
  }

  public function handleProviderCallback (Request $request, $driver)
  {
    if( ! request()->has('code') || request()->has('denied'))
    {
      \Notify::danger( __("Inicio de sesión cancelado") );
      return redirect( '/login' );
    }

    $socialUser = Socialite::driver($driver)->stateless()->user();
    $user       = User::whereEmail($socialUser->email ?? '')->first() ?? null;

    if(! $user )
    {
      $user = User::create([
        'department_id'     => \App\Department::first()->id,
        'name'              => $socialUser->name,
        'email'             => $socialUser->email,
        'remember_token'    => \Str::random(10)
      ])->assignRole( 'postulante' );

      \Notify::success('Cuenta creada con éxito');
    }

    $socialAccount = UserSocialAccount::firstOrCreate([
      "provider_uid"  => $socialUser->id
    ],[
      "user_id"       => $user->id,
      "provider"      => $driver,
      "provider_uid"  => $socialUser->id
    ]);

    $user->update([
        'last_login_at' => now(),
        'last_login_ip' => $request->getClientIp()
    ]);
    
    \Auth::login($user);
    return redirect()->route('home');
  }
}