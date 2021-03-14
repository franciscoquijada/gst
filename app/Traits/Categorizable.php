<?php

namespace App\Traits;

use App\Category;

trait Categorizable
{

    public function category()
    {
        return $this->morphOne( Category::class, 'categorizable')->withDefault();
    }
}