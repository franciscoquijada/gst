<?php 
use App\Log;
use App\Setting;

function log_act($user, $event, $descripcion, $request)
{
    log::create([
        'user_id'       => $user,
        'event'         => $event,
        'description'   => $descripcion,
        'ip'            => $request->ip(),
        'attr'          => $request->all()
        ]);
}

function setting( $key )
{
	return Setting::where( 'key', $key )->withTrashed()->first()->value ?? null;
}

function _lower( $value )
{
	if( is_string( $value ) )
		$value = strtolower( $value );

	return $value;
}
