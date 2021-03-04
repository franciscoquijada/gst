<?php 
use App\Log;
use App\Setting;

function _log($user, $event, $descripcion, $request)
{
    if(! $user instanceof \App\User )
        $user = \App\User::findOrFail($user);

    if($user)
            $user->logs()->create([
        'event'         => $event,
        'description'   => $descripcion,
        'ip'            => $request->ip(),
        'attr'          => $request->all()
    ]);
}

function _setting( $key, $default = '' )
{
    $value = Setting::where( 'key', $key )->withTrashed()->first()->value ?? null;
	return ( $value != null &&  $value != '' ) ? $value : $default;
}

function _lower( $value )
{
	if( is_string( $value ) )
		$value = strtolower( $value );

	return $value;
}

function _format_rut($value)
{
    if( $value != "" )
    {
        $rut = preg_replace( '/[^0-9|k|K]/', '', $value );
        $value = substr( $rut, 0, -1 ) . '-' . substr( $rut, -1 );
    }

    return $value;
}