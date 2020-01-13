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
        $this->middleware(['permission:auditoria']);
    }

    public function index()
    {
        return view( 'logs.index', [ 
            'logs' => Log::all()
        ]);
    }
}
