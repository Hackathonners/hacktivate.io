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
            return is_string($parameters[0])
                ? $validator->validateMax($attribute, $value, [$validator->getData()[$parameters[0]]])
                : $validator->validateMax($attribute, $value, $parameters[0]);
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
            return is_string($parameters[0])
                ? $validator->validateMin($attribute, $value, [$validator->getData()[$parameters[0]]])
                : $validator->validateMin($attribute, $value, $parameters[0]);
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
