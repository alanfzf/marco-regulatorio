<?php

namespace App\Providers;

use App\Repositories\Law\LawRepository;
use App\Repositories\Law\LawRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LawRepositoryInterface::class, LawRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
