<?php

namespace App\Providers;

use App\Contracts\Repositories\TaskRepositoryInterface;
use App\Contracts\Services\Filters\FilterInterface;
use App\Contracts\Services\Filters\Tasks\TaskFilterServiceInterface;
use App\Repositories\TaskRepository;
use App\Services\Filters\MainFilter;
use App\Services\Filters\Tasks\TaskFilter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        TaskRepositoryInterface::class => TaskRepository::class,
        TaskFilterServiceInterface::class => TaskFilter::class,
        FilterInterface::class => MainFilter::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
