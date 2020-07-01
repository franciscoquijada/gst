<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\User;

class AjaxController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_locations(Request $request)
    {
    	$request->validate(['parent_id' => 'required|numeric' ]);
    	
    	$options = Location::where('parent', $request->parent_id )
    		->pluck( "name", "id" );

        $data = ( $options->count() > 0 ) ? 
            view('services.options', ['options' => $options ])->render() : false;
            
    	return response()->json([ 'options' => $data ]);
    }

    public function get_country(Request $request)
    {
        $request->validate(['country' => 'required|numeric' ]);
        
        $attr = Location::findOrFail( $request->country )->attr;

        if( isset( $attr['levels'] ) )
        {
            $options = Location::where('parent', $request->country )
                ->pluck( "name", "id" );
            $attr['options'] = view('services.options', ['options' => $options ])->render();
        }

        return response()->json($attr);
    }

    public function mark_as_read(Request $request)
    {
        \auth::user()->unreadNotifications->markAsRead();
        return response()->json('success', 200);
    }

    public function generate_token(Request $request)
    {
        if(! auth()->user()->can('usuarios:token') ) 
        {
            Response()->json(['error' => 'no tiene permisos para acceder a esta funcion'], 401);
        }

        $user = User::findOrFail( $request->user_id );
        $token = \Str::random(60);

        if( $user->can('usuarios:token') )
        {
            $user->api_token = $token;//hash('sha256', $token);
            $user->save();
            $return = ['token' => $token];
        }
        else
            $return = [ 'token' => 'Este usuario no tiene permisos para acceder a esta funcion'];
        
        return Response()->json($return);
    }
}
