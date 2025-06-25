<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // parent::boot();
    }

    /**
     * Bootstrap services.
     */
    public function shouldDiscoverEvents(): bool
    {
        return true;

    }
}
