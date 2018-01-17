<?php

namespace App\Providers;

use App\Alexa\Models\Settings;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    private $customAttributes;

    public function boot()
    {
        if (App::environment('production')) {
            URL::forceSchema('https');
        }

        /*
         * Validate the size of an attribute is less than a maximum field value.
         *
         * @param  string  $attribute
         * @param  mixed   $value
         * @param  array   $parameters
         * @param  Illuminate\Validation\Validator   $validator
         *
         * @return bool
         */
        Validator::extend('max_field', function ($attribute, $value, $parameters, $validator) {
            $this->customAttributes = $validator->customAttributes ?? [];

            return is_string($parameters[0])
                ? $validator->validateMax($attribute, $value, [$validator->getData()[$parameters[0]]])
                : $validator->validateMax($attribute, $value, $parameters[0]);
        });

        Validator::replacer('max_field', function ($message, $attribute, $rule, $parameters) {
            $attributeName = $this->customAttributes[$parameters[0]] ?? $parameters[0];

            return str_replace(':max_field', $attributeName, $message);
        });

        /*
         * Validate the size of an attribute is greater than a given minimum field value.
         *
         * @param  string  $attribute
         * @param  mixed   $value
         * @param  array   $parameters
         * @param  Illuminate\Validation\Validator   $validator
         *
         * @return bool
         */
        Validator::extend('min_field', function ($attribute, $value, $parameters, $validator) {
            $this->customAttributes = $validator->customAttributes ?? [];

            return is_string($parameters[0])
                ? $validator->validateMin($attribute, $value, [$validator->getData()[$parameters[0]]])
                : $validator->validateMin($attribute, $value, $parameters[0]);
        });

        Validator::replacer('min_field', function ($message, $attribute, $rule, $parameters) {
            $attributeName = $this->customAttributes[$parameters[0]] ?? $parameters[0];

            return str_replace(':min_field', $attributeName, $message);
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
