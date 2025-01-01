<?php

namespace App\Traits;
use Illuminate\Support\Facades\Session;

trait TracksUser
{
    public static function bootTracksUser()
    {
        static::creating(function ($model) {
            $model->created_by = Session::get('user.id');
            $model->updated_by = Session::get('user.id');
        });

        static::updating(function ($model) {
            $model->updated_by = Session::get('user.id');
        });
    }
}
