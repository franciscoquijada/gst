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
