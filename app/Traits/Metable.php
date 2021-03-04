<?php

namespace App\Traits;

use App\Meta;

trait Metable
{
	public function getMeta($key)
    {
        $meta = $this->meta()
            ->where('key', $key )
            ->value('value');

        return $meta ?? false;
    }

    public function hasMeta($key)
    {
        $meta = $this->meta()->where('key', $key );
        return ( $meta->count() > 0 );
    }

    public function meta()
    {
        return $this->morphMany( Meta::class, 'metable');
    }
}