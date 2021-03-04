<?php

namespace App\Traits;

trait SaveLower
{
    public function setAttribute($key, $value)
    {
        $parent = parent::setAttribute( $key, $value );
        
        if ( is_string( $value ) && $parent ) 
        	$parent->attributes[ $key ] = trim( strtolower($value) );
    }
}