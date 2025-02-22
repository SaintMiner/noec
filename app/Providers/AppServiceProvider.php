<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource as Resources;

use App\Resource;
use App\Observers\ResourceObserver;

use App\User;
use App\Observers\UserObserver;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Resources::withoutWrapping();
        
        Resource::observe(ResourceObserver::class);
        User::observe(UserObserver::class);
    }
}
