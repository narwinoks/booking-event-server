<?php

namespace App\Providers;

use App\Interfaces\EventInterface;
use App\Interfaces\UserInterface;
use App\Repositories\EventRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            EventInterface::class,
            EventRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
