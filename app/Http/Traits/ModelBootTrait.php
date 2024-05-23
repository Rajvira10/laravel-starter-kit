<?php

namespace App\Http\Traits;

trait ModelBootTrait
{
    protected static function boot()
    {
        parent::boot();

        if(auth()->check()) {
            static::updating(function ($model) {
                $model->updated_by = auth()->user()->id;
            });
        }
        else{
            static::updating(function ($model) {
                $model->updated_by = 1;
            });
        }

        if(auth()->check()) {
            static::creating(function ($model) {
                $model->updated_by = auth()->user()->id;
            });
        }
        else{
            static::creating(function ($model) {
                $model->updated_by = 1;
            });
        }
    }
}