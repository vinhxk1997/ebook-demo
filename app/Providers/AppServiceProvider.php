<?php

namespace App\Providers;

use App\Repositories\MetaRepository;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Route, Request;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(MetaRepository $meta, UrlGenerator $url)
    {
        if (env('APP_HTTPS', false)) {
            $url->forceScheme('https');
            if (!Request::secure()) {
                return redirect()->secure(Request::getRequestUri())->send();
            }
        }
        if (! Request::ajax()) {
            view()->composer('*', function($view) {
                if (auth()->user() != null) {
                    $user = auth()->user();
                    $noread = $user->notifications()->whereNull('read_at')->count();
                    $notifications = $user->notifications()->orderBy('created_at', 'read_at', 'desc')->get();

                    $view->with('notifications', $notifications);
                    $view->with('noread', $noread);
                }
            });
        }

        if (! (Request::ajax() || (app()->runningInConsole() && !app()->runningUnitTests()) ||
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
