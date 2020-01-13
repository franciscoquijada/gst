<?php

namespace App\Http\Controllers;

use App\User;
use App\Department;

use App\Rules\ValidarRut;
use App\Exports\UsersExport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['permission:listado de usuarios|ver usuarios|crear usuarios|editar usuarios|eliminar usuarios']);
    }

    public function index()
    {
        return view( 'users.index', [
            'users'     => User::with('department')->get(), 
            'deptos'    => Department::pluck('name', 'id'),
            'roles'     => Role::pluck('name', 'id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        //Validamos que los datos cumplan con los requisitos
        $validar = \Validator::make(
            $request->all(),
            [
                'department_id' => 'required',
                'rol_id'        => 'required',
                'rut'           => [ 'required', 'unique:users,rut,NULL,id,deleted_at,NULL', 'string', new ValidarRut],
                'name'          => 'required|string',
                'password'      => 'confirmed',
                'email'         => 'required|unique:users,email,NULL,id,deleted_at,NULL'
            ],[
                'required'      => 'Campo requerido', 
                'rut.unique'    => 'Ya este rut esta registrado', 
                'email.unique'  => 'Ya este email esta en uso'
            ]
        );

        //Si existen errores retornamos cada uno de los errores
        if ( count( $validar->errors() ) > 0)
            return response()->json([
                'status' => 500, 
                'errors' => $validar->errors()
            ]);
        
        $newUser = User::create( $request->all() )->assignRole( $request->rol_id );

        Session::flash('message', 'Usuario registrado con éxito');
        Session::flash('class', 'success');

        return Response()->json($newUser);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::with('department')->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        $user = User::with( 'department','roles' )->find($id);
        return [
            'fields' => $user,
            'route'  => route( 'users.update', $id )
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validamos que los datos cumplan con los requisitos
        $validar = \Validator::make(
            $request->all(),
            [
                'department_id' => 'required',
                'rol_id'        => 'required',
                'rut'           => ['unique:users,rut,'.$id.',id,deleted_at,NULL', 'string', new ValidarRut],
                'name'          => 'required|string',
                'password'      => 'confirmed',
                'email'         => 'required|unique:users,email,'.$id.',id,deleted_at,NULL'
            ],[
                'required'      => 'Campo requerido', 
                'rut.unique'    => 'Ya este rut esta registrado', 
                'email.unique'  => 'Ya este email esta en uso'
            ]
        );

        //Si existen errores            
        if ( count( $validar->errors() ) > 0)
            return response()->json([
                'status' => 500,
                'errors' => $validar->errors()
            ]);
        
        $user = User::find($id);
        $user->update( $request->all() );

        if( $id != 1 )
        {
            $user->syncRoles( $request->rol_id );
            $user->save();
        }

        Session::flash('message', 'Usuario actualizado con éxito');
        Session::flash('class', 'success');

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::find( $id );

        if ($user != null && $id != 1)
        {
            $user->delete();

            Session::flash('message', 'Usuario eliminado con éxito');
            Session::flash('class', 'success');

            return response()->json($user);
        }

        return response()->json([
            'status' => 500,
            'errors' => 'Usuario invalido'
        ]);
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'usuarios.xlsx');
    }
}