<?php

namespace App\Providers;

use App\GoodCat;
use Illuminate\Support\ServiceProvider;
use Validator;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('non_numeric', function($attribute, $value, $parameters, $validator) {
            if(is_numeric($value)){
                return false;
            }
            return true;
        });
        $cats = GoodCat::orderby('cat_index', 'asc')->get();
        View::share('cats', $cats);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
