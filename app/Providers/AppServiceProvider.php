<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\BunnyUploader\BunnyUploader;
use App\Services\BunnyUploader\BunnyVideoLibrary\BunnyLibraryManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Bunny services
        $this->app->singleton(BunnyUploader::class, fn($app) => new BunnyUploader());
        $this->app->singleton(BunnyLibraryManager::class, fn($app) => new BunnyLibraryManager());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
