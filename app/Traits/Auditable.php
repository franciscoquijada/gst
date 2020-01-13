<?php

namespace App\Traits;

use App\Log;
use Illuminate\Database\Eloquent\Model;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function (Model $model) {
            self::audit('creó', $model);
        });

        static::updated(function (Model $model) {
            self::audit('actualizó', $model);
        });

        static::deleted(function (Model $model) {
            self::audit('eliminó', $model);
        });
    }

    protected static function audit($description, $model)
    {
        log::create([
        'user_id'       => auth()->id() ?? null,
        'event'         => $description . ' (ID:' . ( $model->id ?? '?' ) . ')',
        'description'   => get_class($model) ?? null,
        'ip'            => request()->ip() ?? null,
        'attr'          => request()
        ]);
    }
}
