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

function _classes_list()
{
    $classes_root = \File::files( app_path() );

    foreach( $classes_root AS $class )
    {
        $class->classname = str_replace(
            [ app_path(), '/', '.php'],
            ['App', '\\', ''],
            $class->getRealPath()
        );
    }

    $classes = collect($classes_root)->pluck( 'classname', 'classname' );

    foreach ( \Module::all() as $module )
    {
        $moduleName = $module->getName();
        $modulePath = $module->getPath();
        $allFiles   = File::glob( "{$modulePath}/Entities/*.php");

        foreach ( $allFiles as $entity )
        {
            $file   = pathinfo( $entity, PATHINFO_FILENAME );
            $class  = "Modules\\{$moduleName}\\Entities\\{$file}";
            $classes[ $class ] = $class;
        }
        
    }
    
    return $classes;
}

function _setting( $key, $default = '' )
{
    $value = Setting::where( 'key', $key )->withTrashed()->first()->value ?? null;
	return ( $value != null &&  $value != '' ) ? $value : $default;
}

function _lower( $value )
{
  if ( is_string( $value ) )
  {
    return strtolower( $value );
  }
  elseif ( is_array( $value ) )
  {
    $ret = [];
    foreach ( $value as $i => $d ) 
        $ret[ $i ] = ( is_string($value) ) ?
            strtolower( $d ) : _lower( $d );

    return $ret;
  }
  elseif ( is_object($value) )
  {
    foreach ( $value as $i => $d ) 
        $value->$i = ( is_string($value) ) ? 
            strtolower( $d ) : _lower( $d );

    return $value;
  }
  else
  {
    return $value;
  }
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

function _to_utf8($data)
{
  if ( is_string($data) )
  {
    return utf8_encode($data);
  }
  elseif ( is_array($data) )
  {
    $ret = [];
    foreach ($data as $i => $d) 
        $ret[ $i ] = ( is_string($data) ) ? 
            utf8_encode( $d ) : _to_utf8( $d );
            
    return $ret;
  }
  elseif ( is_object($data) )
  {
    foreach ($data as $i => $d) 
        $data->$i = ( is_string($data) ) ? 
            utf8_encode( $d ) : _to_utf8( $d );

    return $data;
  }
  else
  {
    return $data;
  }
}

function _check_rut( $value )
{
    if( trim( $value ) == '' ) 
        return false;

    $_rut   = strtoupper( preg_replace('/\.|,|-/','', $value) );
    $subRut = substr($_rut,0,strlen($_rut)-1);
    $subDv  = substr($_rut,-1);

    $x      = 2;
    $s      = 0;

    for ( $i = strlen( $subRut ) -1; $i >= 0; $i-- )
    {
        if ( $x > 7 )
            $x = 2;

        $s += $subRut[$i]*$x;
        $x++;
    }

    $dv = 11-( $s % 11 );

    if ( $dv==10 )
        $dv = 'K';

    if ( $dv == 11 )
        $dv = '0';

    return( $dv == strtoupper($subDv) );
}