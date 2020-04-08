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
use App\Department;

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
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function register(Request $request)
    {
        $request->merge([ 'rut' => _format_rut( $request->rut ) ]);

        $validar = \Validator::make(
            $request->all(),
            [
                'rut'           => [ 'required', 'unique:users,rut,NULL,id,deleted_at,NULL', 'string', new ValidarRut ],
                'name'          => ['required', 'string', 'max:255'],
                'password'      => ['required', 'string', 'min:8', 'confirmed'],
                'email'         => 'required|email:rfc,dns|unique:users,email,NULL,id,deleted_at,NULL'
            ],[
                'required'      => 'Campo requerido', 
                'rut.unique'    => 'Ya este rut esta registrado', 
                'email.unique'  => 'Ya este email esta en uso'
            ]
        );

        if ( count( $validar->errors() ) > 0)
            return response()->json([
                'status' => 400, 
                'errors' => $validar->errors()
            ]);
        
        $newUser = User::create([
            'rut'               => $request->rut,
            'department_id'     => _setting( 'depto_default', 1 ),
            'phone'             => $request->phone,
            'name'              => $request->name,
            'email'             => $request->email,
            'attr'              => '',
            'password'          => Hash::make( $request->password ),
        ])->assignRole( _setting( 'role_default', 2 ) );

        log::create([
            'user_id'       => $newUser->id,
            'event'         => 'se registró (ID:' . $newUser->id . ')',
            'description'   => 'App\User',
            'ip'            => $request->ip(),
            'attr'          => $newUser
        ]);

        auth()->loginUsingId( $newUser->id );

        \Notify::success('Se ha creado tu cuenta con éxito');
        return Response()->json([ 'newUser' => $newUser, 'redirect' => $this->redirectTo ]);
    }
}
