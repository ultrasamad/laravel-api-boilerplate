<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Remove the custom route attributes, if your default auth guard is web
        Broadcast::routes([
            'prefix' => 'api',
            'middleware' => ['auth:api', 'cors']
        ]);

        require base_path('routes/channels.php');
    }
}
