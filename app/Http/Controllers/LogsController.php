<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['permission:registros:listado']);
    }

    public function list()
    {
        $data = Log::latest();

        return \DataTables::of( $data )
            ->editColumn( 'created_at', function( $col )
            {
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
        $columns = [
            [
                'data'      => 'event', 
                'name'      => 'event', 
                'title'     => 'Evento', 
                'className' => 'text-center'
            ],
            [
                'name'      => 'loggable_id', 
                'title'     => 'Usuario', 
                'className' => 'text-center text-capitalize', 
                'data'      => [
                    '_'     => 'loggable.name',
                    'sort'  => 'loggable.name'
                ]
            ],
            [
                'data'      => 'description',
                'name'      => 'description',
                'title'     => 'Descripción',
                'className' => 'text-center'
            ],
            [
                'data'      => 'ip',
                'name'      => 'ip',
                'title'     => 'IP',
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
            ]
        ];

        return view( 'logs.index', [ 'columns' => $columns ]);
    }
}
