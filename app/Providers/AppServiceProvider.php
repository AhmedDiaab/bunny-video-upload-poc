<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Bunny\BunnyUploader;
use App\Services\Bunny\BunnyVideo\BunnyVideoManager;
use App\Services\Bunny\BunnyVideo\BunnyVideoMetadataManager;
use App\Services\Bunny\BunnyVideoCollection\BunnyCollectionManager;
use App\Services\Bunny\BunnyVideoLibrary\BunnyLibraryManager;

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
        $this->app->singleton(BunnyCollectionManager::class, fn($app) => new BunnyCollectionManager());
        $this->app->singleton(BunnyVideoManager::class, fn($app) => new BunnyVideoManager());
        $this->app->singleton(BunnyVideoMetadataManager::class, fn($app) => new BunnyVideoMetadataManager());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
