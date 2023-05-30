<?php

namespace App\Providers;

use App\Contracts\Manager\ShiftManagerInterface;
use App\Contracts\Manager\ShiftManagerServiceInterface;
use App\Contracts\Workers\WorkerShiftInterface;
use App\Contracts\Workers\WorkShiftServiceInterface;
use App\Repositories\Manager\ShiftManagerRepository;
use App\Repositories\Workers\WorkerShiftRepository;
use App\Services\Manager\ShiftManagerService;
use App\Services\Workers\WorkerShiftService;
use Illuminate\Support\ServiceProvider;

class WorkerShiftServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(WorkerShiftInterface::class, WorkerShiftRepository::class);
        $this->app->bind(WorkShiftServiceInterface::class, WorkerShiftService::class);
        $this->app->bind(ShiftManagerInterface::class, ShiftManagerRepository::class);
        $this->app->bind(ShiftManagerServiceInterface::class, ShiftManagerService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
