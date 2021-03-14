<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Meta;

class MetasController extends Controller
{
	public function list()
    {
    	$data = ( request()->has('trashed') ) ?
            Meta::onlyTrashed()->latest():
            Meta::latest();

        return \DataTables::of( $data )
            ->addColumn( 'action', 'metadata.partials.buttons' )
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
    	$models     = _classes_list();
        $columns    = [
            [
                'data'      => 'name', 
                'name'      => 'name', 
                'title'     => 'Nombre', 
                'className' => 'text-center text-capitalize'
            ],
            [
                'data'      => 'key', 
                'name'      => 'key', 
                'title'     => 'Llave', 
                'className' => 'text-center'
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
        
        return view( 'metadata.index', [
        	'models'    => $models,
            'columns'   => $columns
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
        $data = $request->validate([
                'key'           => 'required|min:3|string',
                'name'          => 'required|min:3|string',
                'rules'         => 'required|min:3|string',
                'model'         => 'required|min:3|string'
            ],[
                'required'      => 'Campo requerido', 
                'min'           => 'Longitud minima permitida de 3 caracteres'
            ]);

        array_walk($data, function( &$i, $k )
            {
                $i = ( $k != 'model' ) ? 
                    strtolower( $i ) : $i;
            }, $data);

        $newMeta = Meta::create( $data );

        \Notify::success('Metadata creada con éxito');

        return response()->json( $newMeta );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        return Meta::findOrFail($id);
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
            'fields' => Meta::findOrFail($id),
            'route'  => route( 'api.metadata.update', $id )
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
                'key'           => 'required|min:3|string',
                'name'          => 'required|min:3|string',
                'rules'         => 'required|min:3|string',
                'model'         => 'required|min:3|string'
            ],[
                'required'      => 'Campo requerido', 
                'min'           => 'Longitud minima permitida de 3 caracteres'
            ]);

        array_walk($data, function( &$i, $k )
            {
                $i = ( $k != 'model' ) ? 
                    strtolower( $i ) : $i;
            }, $data);

        $meta = Meta::findOrFail($id)
        	->update( $data );

        \Notify::success('Metadata actualizada con éxito');
             
        return response()->json( $meta );
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $item = Meta::findOrFail($id);

        if( $item != null )
        {
            $item->delete();
        
            \Notify::success('Metadata eliminada con éxito');

            return response()->json( true );
        }
        
        return response()->json([
            'message' => 'Datos invalidos', 
            'errors'  => ['id' => 'Metadata invalida']
        ], 422);
    }
}
