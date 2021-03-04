<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

use App\Rules\ValidarRut;

use App\User;
use App\Log;
use App\Group;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function showRegistrationForm()
    {
        return view( 'auth.register');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function register(Request $request)
    {
        $data = $request
            ->validate([
                'name'          => ['required', 'string', 'max:255'],
                'password'      => ['required', 'string', 'min:8', 'confirmed'],
                'email'         => 'required|email:rfc,dns|unique:users,email,NULL,id,deleted_at,NULL'
            ],[
                'required'      => 'Campo requerido', 
                'min'           => 'Es muy corto',
                'max'           => 'Es muy largo',
                'rut.unique'    => 'Ya este rut esta registrado', 
                'email.unique'  => 'Ya este email esta en uso'
            ]
        );

        $data['group_id']       = _setting( 'group_default', 1 );
        $role_default           = _setting( 'role_default', false );
        $data['last_login_at']  = now();
        $data['last_login_ip']  = $request->getClientIp();

        $newUser = User::create( $data );

        if( $role_defaul )
            $newUser->assignRole( $role_default );

        $newUser->logs()->create([
            'event'         => 'se registró (ID:' . $newUser->id . ')',
            'description'   => 'App\User',
            'ip'            => $request->ip(),
            'attr'          => $newUser
        ]);

        auth()->loginUsingId( $newUser->id );

        \Notify::success('Se ha creado tu cuenta con éxito');

        return Response()->json([ 
            'newUser'  => true, 
            'redirect' => $this->redirectTo 
        ], 200, array('Content-Type'=>'application/json; charset=utf-8' ));
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    public function redirectTo()
    {
        return route('home');
    }
}
