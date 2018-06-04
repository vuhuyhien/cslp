<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Contracts\ChangeEmailRepositoryInterface',
            'App\Repositories\Eloquent\ChangeEmailRepository'
            
        );

        $this->app->bind(
            'App\Repositories\Contracts\UserRepositoryInterface',
            'App\Repositories\Eloquent\UserRepository'
            
        );
        
        $this->app->bind(
            'App\Repositories\Contracts\CreateCategoryRepositoryInterface',
            'App\Repositories\Eloquent\CategoryRepository'
        );
    }
}
