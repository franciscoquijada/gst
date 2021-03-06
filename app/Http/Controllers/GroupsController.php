<?php

namespace App\Http\Controllers;

use Cache;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Exports\GroupExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Group;
use App\User;

use Validator;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(['permission:grupos:listado|grupos:crear|grupos:editar|grupos:eliminar']);
    }

    public function index()
    {
        $columns = [
            [
                'data'      => 'name',
                'name'      => 'name', 
                'title'     => 'Grupo', 
                'className' => 'text-center text-capitalize'
            ],
            [
                'data'       => 'users_count', 
                'name'       => 'users_count', 
                'title'      => 'Usuarios', 
                'searchable' => false,
                'className'  => 'text-center'
            ],
            [
                'name'      => 'created_at', 
                'title'     => 'Fecha', 
                'className' => 'text-center', 
                'data'      => [ 
                    '_'     => 'created_at.display', 
                    'sort'  => 'created_at.timestamp' 
                ]
            ],
            [
                'data'       => 'action', 
                'name'       => 'acciones', 
                'orderable'  => false, 
                'searchable' => false, 
                'className'  => 'text-center actions'
            ]
        ];
            
        return view('groups.index', [
            'columns'   => $columns
        ]);
    }

    public function list()
    {
        $data = ( request()->has('trashed') ) ?
            Group::onlyTrashed()->withCount('users')->latest():
            Group::withCount('users')->latest();

        return \DataTables::of( $data )
            ->editColumn('created_at', function($col) {
                return [
                    'display' => ( $col->created_at && $col->created_at != '0000-00-00 00:00:00' ) ?
                        with( new \Carbon\Carbon($col->created_at) )->format('d/m/Y H:i:s') : '',
                    'timestamp' =>( $col->created_at && $col->created_at != '0000-00-00 00:00:00' ) ?
                        with( new \Carbon\Carbon($col->created_at) )->timestamp : ''
                    ];
                })
            ->addColumn( 'action', 'groups.partials.buttons' )
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
                'name'          => 'required|min:3|string|unique:groups,name,NULL,id,deleted_at,NULL'
            ],[
                'required'      => 'Campo requerido',
                'min'           => 'Longitud minima permitida de 3 caracteres'
            ]);

        Group::create( $data );

        \Notify::success('Grupo creado con ??xito');

        return response()->json(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return [
            'fields' => Group::findOrFail($id),
            'route'  => route( 'api.groups.update', $id )
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
        $data = $request->validate([
                'name'          => 'required|min:3|string|unique:groups,name,'.$id.',id,deleted_at,NULL'
            ],[
                'required'      => 'Campo requerido',
                'min'           => 'Longitud minima permitida de 3 caracteres'
            ]);

        $item = Group::findOrFail($id);
        $item->update($data);

        \Notify::success('Grupo actualizado con ??xito');

        return response()->json( true );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $item = Group::findOrFail($id);

        if( $item != null && $id != 1 )
        {
            $item->delete();

            \Notify::success('Grupo eliminado con ??xito');

            return response()->json(true);
        }

        return response()->json([
            'message' => 'Datos invalidos',
            'errors'  => ['id' => 'Grupo invalido']
        ], 422);
    }

    public function export()
    {
        return Excel::download(new GroupExport, 'Grupos.xlsx');
    }
}
