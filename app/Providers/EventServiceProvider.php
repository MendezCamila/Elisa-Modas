<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\Cover;
use App\Observers\CoverObserver;
use CodersFree\Shoppingcart\Facades\Cart;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
        Login::class => [
            RestoreCartOnLogin::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //\App\Models\Cover::observe(\App\Observers\CoverObserver::class);
        Cover::observe(CoverObserver::class);


        //
    }
}
