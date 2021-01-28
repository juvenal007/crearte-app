<?php

namespace App\Providers;

use App\Factory\Contracts\CreateCentroCostoInterface;
use App\Factory\CreateCentroCosto;
use App\JsonResponse\Contracts\ListResponseInterface;
use App\JsonResponse\ListResponse;
use App\Repositories\Contracts\CentroCostoRepoInterface;
use App\Repositories\Factory\CentroCostoRepo;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CreateCentroCostoInterface::class, CreateCentroCosto::class);
        $this->app->bind(CentroCostoRepoInterface::class, CentroCostoRepo::class);
        $this->app->bind(ListResponseInterface::class, ListResponse::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
