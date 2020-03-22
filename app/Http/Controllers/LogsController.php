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

    public function index()
    {
        if(request()->ajax() )
        {
            $data = Log::latest()->get();

/*
            // retorno la data a datatables
            return Datatables::of( $data )
            // agrego la columna de action
            ->addColumn( 'action', function ( $data ) // declaro los botones que necesito y les paso los parametros
            {
                $btn[] = (Auth::user()->can('ver usuario')) ?
                    '<a href="'. route( 'users.show', $data->id ) . '" title="Ver" class="btn-info"><i class="fas fa-eye"></i></a>' : '';
                
                $btn[] = (Auth::user()->can('actualizar usuario')) ?
                    '<a href="'. route( 'users.edit', $data->id ) . '" title="Editar" class="btn-warning"><i class="far fa-edit"></i></a>' : '';
                
                if( $data->id != 1 ) 
                $btn[] = ( Auth::user()->can('eliminar usuario') ) ? 
                '<a href="#" title="Eliminar" onclick="eliminarUser('.$data->id.')" class="btn-danger"><i class="far fa-trash-alt"></i></a>' : '';

                return implode( '', $btn );

            })
            ->rawColumns(['id','name','email','rol','action']) //creo las columnas
            ->make(true); // ejecuto la creacion*/
        }
        
        return view( 'logs.index', [ 
            'logs' => Log::all()
        ]);
    }

    public function indexData()
    {
        $data = Log::get();

        return Datatables::of( $data )
        ->rawColumns([ 'id', 'user.name', 'event', 'descriptio', 'ip', 'created_at'])
        ->make(true);
    }
}
