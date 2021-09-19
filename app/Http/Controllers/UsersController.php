<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\User;
use App\Log;
use App\Group;
use App\Identification;

use App\Rules\ValidarRut;
use App\Exports\UsersExport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
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
                'data'      => 'role_name',
                'name'      => 'role_name',
                'title'     => 'Permisos',
                'className' => 'text-center'
            ],
            [
                'data'      => 'email',
                'name'      => 'email',
                'title'     => 'Email',
                'className' => 'text-center'
            ],
            [
                'name'      => 'last_login_at.timestamp',
                'title'     => 'Ult. Ingreso',
                'className' => 'text-center',
                'data'      => [
                    '_'     => 'last_login_at.display',
                    'sort'  => 'last_login_at.timestamp'
                ]
            ],
            [
                'data'          => 'action',
                'name'          => 'acciones',
                'orderable'     => false,
                'searchable'    => false,
                'className'     => 'text-center actions'
            ]
        ];

        return view( 'users.index', [
            'groups'    => Group::pluck('name', 'id'),
            'roles'     => Role::pluck('name', 'id'),
            'columns'   => $columns
        ]);
    }

    public function list()
    {
        $data = ( request()->has('trashed') ) ?
            User::onlyTrashed()->with(['group', 'roles'])->latest():
            User::with(['group', 'roles'])->latest();

        return \DataTables::of( $data )
            ->addColumn( 'action', 'users.partials.buttons' )
            ->addColumn( 'role_name', function( $data ){ return $data->roles[0]->name ?? ''; })
            ->editColumn('last_login_at', function($col) {
                return [
                    'display' => ( $col->last_login_at && $col->last_login_at != '0000-00-00 00:00:00' ) ?
                        with( new \Carbon\Carbon($col->last_login_at) )->format('d/m/Y H:i:s') : '',
                    'timestamp' =>( $col->last_login_at && $col->last_login_at != '0000-00-00 00:00:00' ) ?
                        with( new \Carbon\Carbon($col->last_login_at) )->timestamp : ''
                    ];
                })
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        User::create( $request->all() )->assignRole( $request->rol_id );
        \Notify::success('Usuario registrado con éxito');
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
        return User::with(['group','roles'])->findOrFail($id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view( 'users.profile', [
            'user'    => User::findOrFail( auth()->id() )
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        $user = User::with( 'group','roles' )->findOrFail($id);
        return [
            'fields' => $user,
            'route'  => route( 'api.users.update', $id )
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        if( $id != 1 )
        {
            $user->syncRoles( $request->rol_id );
            $user->save();
        }

        \Notify::success('Usuario actualizado con éxito');
        return response()->json(true);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_profile(Request $request )
    {
        $id = auth()->id();
        $data = $request
            ->merge([ 'rut' => _format_rut( $request->rut ) ])
            ->validate([
                'password'      => 'nullable|confirmed|string|min:8',
                'email'         => 'required|email:rfc,dns|unique:users,email,'.$id.',id,deleted_at,NULL'
            ],[
                'required'      => 'Campo requerido',
                'rut.unique'    => 'Ya este rut esta registrado',
                'email.unique'  => 'Ya este email esta en uso'
            ]
        );

        $user = User::findOrFail($id);
        $user
            ->update( $data )
            ->log()
            ->create([
                'event'         => 'actualizó (ID:' . $id . ')',
                'description'   => 'App\User',
                'ip'            => $request->ip(),
                'attr'          => $user
            ]);

        \Notify::success('Perfil actualizado con éxito');
        return Response()->json([
            'newUser'  => $user,
            'redirect' => route('home')
        ]);
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
            \Notify::success('Usuario eliminado con éxito!');
            return response()->json($user);
        }

        return response()->json([
            'message' => 'Datos invalidos',
            'errors'  => ['id' => 'Usuario invalido']
        ], 422);
    }

    public function export()
    {
        return \Excel::download(new UsersExport, 'usuarios.xlsx');
    }
}
