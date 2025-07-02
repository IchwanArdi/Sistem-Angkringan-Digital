<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Order;
use App\Policies\MenuPolicy;
use App\Policies\OrderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Menu::class => MenuPolicy::class,
        Order::class => OrderPolicy::class, // hanya jika kamu punya OrderPolicy
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
