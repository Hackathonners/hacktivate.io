<?php

namespace App\Providers;

use App\Alexa\Models\Settings;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * Validate the size of an attribute is less than a maximum field value.
         *
         * @param  string  $attribute
         * @param  mixed   $value
         * @param  array   $parameters
         * @param  Illuminate\Validation\Validator   $validator
         * @return bool
         */
        Validator::extend('max_field', function ($attribute, $value, $parameters, $validator) {
            if (count($parameters) === 1) {
                if (is_numeric($parameters[0])) {
                    return $validator->validateMax($attribute, $value, $parameters);
                } elseif (is_string($parameters[0])) {
                    $data = $validator->getData();
                    $parametersValue = $data[$parameters[0]];
                    if (! is_null($parametersValue)) {
                        return $validator->validateMax($attribute, $value, [$parametersValue]);
                    }
                }
            }

            return false;
        });

        /*
         * Validate the size of an attribute is greater than a given minimum field value.
         *
         * @param  string  $attribute
         * @param  mixed   $value
         * @param  array   $parameters
         * @param  Illuminate\Validation\Validator   $validator
         * @return bool
         */
        Validator::extend('min_field', function ($attribute, $value, $parameters, $validator) {
            if (count($parameters) === 1) {
                if (is_numeric($parameters[0])) {
                    return $validator->validateMin($attribute, $value, $parameters);
                } elseif (is_string($parameters[0])) {
                    $data = $validator->getData();
                    $parametersValue = $data[$parameters[0]];
                    if (! is_null($parametersValue)) {
                        return $validator->validateMin($attribute, $value, [$parametersValue]);
                    }
                }
            }

            return false;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('settings', function ($app) {
            return Settings::firstOrNew([]);
        });
    }
}
