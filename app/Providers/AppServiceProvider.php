<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Avoid database unique field naming schema error
        Schema::defaultStringLength(191);

        // Use bootstrap CSS as default pagination UI
        Paginator::useBootstrap();

        /**
         * Extend laravel form validation rules
         */
        Validator::extend('phone', function ($attribute, $value, $parameters, $validator) {
            return preg_match('%^(?:(88)|(\+88)|(0088))?(01)[0-9]{9}\r?$%i', $value) && strlen($value) >= 10;
        });

        Validator::replacer('phone', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, ':attribute is invalid phone number (e.g 01510123456)');
        });

        // Blade syntax block for specific user roles
        Blade::if('admin', function () {
            return has_role(auth()->user(), 'superadmin|admin');
        });

        Blade::if('user', function () {
            return has_role(auth()->user(), 'student|teacher|owner');
        });
    }
}
