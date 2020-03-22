<?php

namespace App\Library\Services;


use Illuminate\Support\Facades\Facade;

class PNotify extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'pnotify';
    }
}