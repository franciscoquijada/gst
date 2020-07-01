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
        if( request()->ajax() )
            return \DataTables::of( Log::latest() )
                ->editColumn('created_at', function($col) {
                    return [
                        'display' => ( $col->created_at && $col->created_at != '0000-00-00 00:00:00' ) ? 
                            with( new \Carbon\Carbon($col->created_at) )->format('d/m/Y H:i:s') : '',
                        'timestamp' =>( $col->created_at && $col->created_at != '0000-00-00 00:00:00' ) ? 
                            with( new \Carbon\Carbon($col->created_at) )->timestamp : ''
                        ];
                    })
                ->toJson();
        
        return view( 'logs.index');
    }
}
