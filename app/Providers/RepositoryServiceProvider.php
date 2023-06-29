<?php

namespace App\Providers;

use app\Interfaces\CheckinInterface;
use App\Interfaces\EventInterface;
use App\Interfaces\OrderDetailInterface;
use App\Interfaces\OrderInterface;
use App\Interfaces\PaymentLogInterface;
use App\Interfaces\TicketsInterface;
use App\Interfaces\UserInterface;
use App\Repositories\EventRepository;
use App\Repositories\OrderDetailRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentLogRepository;
use App\Repositories\TicketsRepository;
use App\Repositories\UserRepository;
use  App\Repositories\CheckinRepository;
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
        $this->app->bind(
            TicketsInterface::class,
            TicketsRepository::class
        );
        $this->app->bind(
            OrderInterface::class,
            OrderRepository::class
        );
        $this->app->bind(
            OrderDetailInterface::class,
            OrderDetailRepository::class
        );
        $this->app->bind(
            PaymentLogInterface::class,
            PaymentLogRepository::class
        );
        $this->app->bind(
            CheckinInterface::class,
            CheckinRepository::class
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
