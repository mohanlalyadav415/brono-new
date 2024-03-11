<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ChileanRutServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('chilean_rut', function ($attribute, $value, $parameters, $validator) {
            // Validate Chilean RUT using a regular expression
            return preg_match('/^\d{2}\.\d{3}\.\d{3}-[\dkK]$/', $value) === 1;
        });
    }

    public function register()
    {
        //
    }
}

