<?php

namespace App\Http\Controllers;

use App\User;
use App\Log;
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
        $this->middleware(['permission:usuarios:listado|usuarios:ver|usuarios:crear|usuarios:actualizar|usuarios:eliminar']);
    }

    public function index()
    {
        if( request()->ajax() )
            return \DataTables::of( User::with('department')->latest()->get() )
            ->addColumn( 'action', 'users.partials.buttons' )
            ->addColumn( 'role_name', function( $data ){ return $data->getRoleNames()[0]; })
            ->toJson();

        return view( 'users.index', [ 
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
        $request->merge([ 'rut' => _format_rut( $request->rut ) ]);

        $validar = \Validator::make(
            $request->all(),
            [
                'department_id' => 'required',
                'rol_id'        => 'required',
                'rut'           => [ 'required', 'unique:users,rut,NULL,id,deleted_at,NULL', 'string', new ValidarRut ],
                'name'          => 'required|string',
                'password'      => 'confirmed',
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
        
        $newUser = User::create( $request->all() )->assignRole( $request->rol_id );

        log::create([
            'user_id'       => auth()->id() ?? null,
            'event'         => 'creó (ID:' . $newUser->id . ')',
            'description'   => 'App\User',
            'ip'            => $request->ip(),
            'attr'          => $newUser
        ]);

        \PNotify::success('Usuario registrado con éxito');
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
        return User::with('department')->findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        $user = User::with( 'department','roles' )->findOrFail($id);
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
        $request->merge([ 'rut' => _format_rut( $request->rut ) ]);

        $validar = \Validator::make(
            $request->all(),
            [
                'department_id' => 'required',
                'rol_id'        => 'required',
                'rut'           => [ 'unique:users,rut,' . $id . ',id,deleted_at,NULL', 'string', new ValidarRut ],
                'name'          => 'required|string',
                'password'      => 'confirmed',
                'email'         => 'required|email:rfc,dns|unique:users,email,'.$id.',id,deleted_at,NULL'
            ],[
                'required'      => 'Campo requerido', 
                'rut.unique'    => 'Ya este rut esta registrado', 
                'email.unique'  => 'Ya este email esta en uso'
            ]
        );

        //Si existen errores            
        if ( count( $validar->errors() ) > 0 )
            return response()->json([
                'status' => 400,
                'errors' => $validar->errors()
            ]);
        
        $user = User::findOrFail($id);
        $user->update( $request->all() );

        if( $id != 1 )
        {
            $user->syncRoles( $request->rol_id );
            $user->save();
        }

        log::create([
            'user_id'       => auth()->id() ?? null,
            'event'         => 'actualizó (ID:' . $id . ')',
            'description'   => 'App\User',
            'ip'            => $request->ip(),
            'attr'          => $user
        ]);

        \PNotify::success('Usuario actualizado con éxito');
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
        $user = User::findOrFail( $id );

        if ($user != null && $id != 1)
        {
            $user->delete();

            log::create([
                'user_id'       => auth()->id() ?? null,
                'event'         => 'eliminó (ID:' . $id . ')',
                'description'   => 'App\User',
                'ip'            => $request->ip(),
                'attr'          => $user
            ]);

            \PNotify::success('Usuario eliminado con éxito!');
            return response()->json($user);
        }

        return response()->json([
            'status' => 400,
            'errors' => 'Usuario invalido'
        ]);
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'usuarios.xlsx');
    }
}