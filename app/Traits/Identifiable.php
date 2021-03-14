<?php

namespace App\Traits;

use App\IdentificationType;
use App\Identification;

trait Identifiable
{
	public function initializeIdentifiable()
    {
        $this->with[] 		= 'identifications';
        $this->appends[]    = 'external_html';
        $this->appends[]    = 'externals';
    }

    public function identifications()
    {
        return $this->morphMany(Identification::class, 'identifications');
    }

	public function identificationstypes()
    {
        return $this->morphToMany( IdentificationType::class, 'identifications')
        	->using( Identification::class )
        	->withTimestamps();
    }

    public function getExternalsAttribute()
    {
        $identifications = [];

        $this->identifications->each( function( $item ) use( &$identifications )
        {
            $identifications[ $item->type->id ] = [
                'type'  => $item->type->name,
                'value' => $item->value,
            ];
        });

        return $identifications;
    }

    public function getExternalHtmlAttribute()
    {
        return view('identifications_types.partials.externals', [ 
            'identifications' => $this->identifications 
        ])->render();
    }
}