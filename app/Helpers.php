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

function _encrypt($string) 
{ 
    /* Defina la palabra secreta para encriptar */
    $key="w3he+1+!";
    $result = ''; 
    for($i=0; $i<strlen($string); $i++)
        {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)+ord($keychar));
            $result.=$char;
        }
    $tmpencode=base64_encode($result);
    return str_replace("=", "EQ", str_replace("&", "AND", str_replace("+","PLUS", $tmpencode)));
}

function _decrypt($string) 
{ 
    /* La palabra secreta para desencriptar igual que la de encriptar */
    $key="w3he+1+!";
    $result = ''; 
    $string=str_replace("EQ", "=", str_replace("AND", "&", str_replace("PLUS","+", $string)));
    $string = base64_decode($string); 
    for($i=0; $i<strlen($string); $i++) 
        { 
            $char = substr($string, $i, 1); 
            $keychar = substr($key, ($i % strlen($key))-1, 1); 
            $char = chr(ord($char)-ord($keychar)); 
            $result.=$char; 
        } 
    return $result; 
}