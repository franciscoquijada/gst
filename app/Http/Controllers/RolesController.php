<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use Validator;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['permission:roles:listado|roles:ver|roles:crear|roles:editar|roles:eliminar']);
    }

    public function list()
    {
        $data = Role::withCount('users')->latest();

        return \DataTables::of( $data )
            ->addColumn( 'action', 'roles.partials.buttons' )
            ->toJson();
    }

    public function index()
    {
        $columns = [
            [
                'data'      => 'name', 
                'name'      => 'name', 
                'title'     => 'Nombre', 
                'className' => 'text-center text-capitalize'
            ],
            [
                'data'      => 'users_count', 
                'name'      => 'users', 
                'title'     => 'Usuarios',
                'searchable' => false,
                'className' => 'text-center'
            ],
            [
                'data'       => 'action', 
                'name'       => 'acciones', 
                'orderable'  => false, 
                'searchable' => false, 
                'className'  => 'text-center actions'
            ]
        ];

        $system = [];
        $modules = [];

        foreach ( Permission::all() as $key => $p)
        {
            $name =  explode(':', $p->name);
            if( isset( $name[2] ) )
                $modules[ $name[0] ][ $name[1] ][ $name[2] ] = $p->id;
            else
                $system[ $name[0] ][ $name[1] ] = $p->id;
        }

        return view('roles.index', [ 
            'permissions'   => Permission::all(),
            'system'        => $system,
            'mod'           => $modules,
            'columns'       => $columns
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
        $validar = Validator::make(
            $request->all(),
            [
                'name'       => 'required|unique:roles,name,NULL,id,deleted_at,NULL',
                'permission' => 'required',
            ],[
                'required'      => 'Campo requerido',
                'unique'        => 'Ya este nombre esta en uso'
            ]
        )->validate();

        $newRole = Role::create([ 
            'name' => strtolower( $request->name )
        ]);

        $newRole->syncPermissions( $request->permission );

        \Notify::success('Rol creado con éxito');

        return Response()->json(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return $role;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return [
            'fields' => $role,
            'route'  => route( 'api.roles.update', $id )
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
        $validar = Validator::make(
            $request->all(),
            [
                'name'       => 'required|unique:roles,name,'.$id.',id,deleted_at,NULL',
                'permission' => 'required',
            ],[
                'required'      => 'Campo requerido',
                'unique'        => 'Ya este nombre esta en uso'
            ]
        )->validate();

        if( $id != 1 )
        {
            $role = Role::findOrFail($id);
            $role->name = strtolower( $request->name );
            $role->save();
            $role->syncPermissions( $request->permission );

            \Notify::success('Rol actualizado con éxito');

            return response()->json($role);
        }
        else
        {
            return response()->json(false);
            \Notify::error('No tiene permiso para actualizar el rol super-admin');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $rol = Role::findOrFail($id);

        if ( $id != 1 && $rol != null && $rol->users()->count() == 0)
        {
            $rol->delete();
            \Notify::success('Rol eliminado con éxito');

            return response()->json($rol);
        }

        return response()->json([
                'message' => 'Datos invalidos', 
                'errors'  => ['id' => 'Este rol tiene usuarios asociados a el o es invalido'] 
            ], 422);
    }
}
