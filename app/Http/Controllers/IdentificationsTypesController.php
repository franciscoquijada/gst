<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IdentificationType;

class IdentificationsTypesController extends Controller
{
	public function __construct()
    {
        $this->middleware(['permission:tipos identificadores:listado|tipos identificadores:crear|tipos identificadores:editar|tipos identificadores:eliminar']);
    }

    public function list()
    {
        $data = IdentificationType::latest();

        return \DataTables::of( $data )
            ->addColumn( 'action', 'identifications_types.partials.buttons' )
            ->editColumn('created_at', function($col) {
                return [
                    'display' => ( $col->created_at && $col->created_at != '0000-00-00 00:00:00' ) ? 
                        with( new \Carbon\Carbon($col->created_at) )->format('d/m/Y H:i:s') : '',
                    'timestamp' =>( $col->created_at && $col->created_at != '0000-00-00 00:00:00' ) ? 
                        with( new \Carbon\Carbon($col->created_at) )->timestamp : ''
                    ];
                })
            ->toJson();
    }

    public function index()
    {
    	$models     = $this->getClassesList();
        $columns    = [
            [
                'data'      => 'name', 
                'name'      => 'name', 
                'title'     => 'Tipo', 
                'className' => 'text-center text-capitalize'
            ],
            [
                'data'      => 'model', 
                'name'      => 'model', 
                'title'     => 'Modelo', 
                'className' => 'text-center'
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
        
        return view( 'identifications_types.index', [
        	'models'    => $models,
            'columns'   => $columns
        ]);
    }

    public function getClassesList()
    {
    	$classes = \File::files( app_path() );
    	foreach ($classes as $class)
    	{
    		$class->classname = str_replace(
    			[app_path(), '/', '.php'],
    			['App', '\\', ''],
    			$class->getRealPath()
    		);
    	}
    	return collect($classes)->pluck( 'classname', 'classname' );
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
                'name'          => 'required|min:3|string',
                'model'         => 'required|min:3|string'
            ],[
                'required'      => 'Campo requerido', 
                'min'           => 'Longitud minima permitida de 3 caracteres'
            ]);
        
        IdentificationType::create( $data );

        \Notify::success('Tipo de identificación creado con éxito');

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
            'fields' => IdentificationType::findOrFail($id),
            'route'  => route( 'api.id_types.update', $id )
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
                'name'          => 'required|min:3|string',
                'model'         => 'required|min:3|string'
            ],[
                'required'      => 'Campo requerido', 
                'min'           => 'Longitud minima permitida de 3 caracteres'
            ]);
                 
        $item = IdentificationType::findOrFail($id);
        $item->update( $data );

        \Notify::success('Tipo de identificación actualizado con éxito');
             
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
        $item = IdentificationType::findOrFail($id);

        if( $item != null && $id != 1 )
        {
            $item->delete();
        
            \Notify::success('Tipo de identificación eliminado con éxito');

            return response()->json( true );
        }
        
        return response()->json([
            'message' => 'Datos invalidos', 
            'errors'  => ['id' => 'Tipo de identificación invalido']
        ], 422);
    }
}