<?php

namespace App\Providers;

use App\Repositories\MetaRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Route, Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(MetaRepository $meta)
    {
        if (! (Request::ajax() || app()->runningInConsole() ||
            Route::is('login') || Route::is('register')
            && Route::is('admin/*') || Route::is('password/*') || Route::is('email/*')
        )) {
            $categories = $meta->getCategories();
            View::share('categories', $categories);
            View::share('keyword', Route::is('search') ? Request::query('q') : null);
        }
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
