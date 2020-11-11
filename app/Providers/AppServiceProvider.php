<?php

namespace App\Providers;

use App\Repositories\Revenue\EloquentRevenueRepository;
use App\Repositories\Revenue\RevenueRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected array $reps = [
        RevenueRepository::class => EloquentRevenueRepository::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register ()
    {
        foreach ($this->reps as $definition => $rep) {
            $this->app->bind($definition, $rep);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot ()
    {
        Schema::defaultStringLength(191);
    }
}
