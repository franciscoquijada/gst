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
            return \DataTables::of( Log::latest()->get() )
                ->rawColumns([ 'id', 'user_name', 'event', 'description', 'ip', 'created_at'])
                ->make(true);
        
        return view( 'logs.index');
    }
}
