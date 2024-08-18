<?php

namespace App\Providers;

use App\Interfaces\CustomerRepositoryInterface;
use App\Interfaces\QualityRepositoryInterface;
use App\Interfaces\SupplierRepositoryInterface;
use App\Repositories\CustomerRepository;
use App\Repositories\QualityRepository;
use App\Repositories\SupplierRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(SupplierRepositoryInterface::class, SupplierRepository::class);
        $this->app->bind(QualityRepositoryInterface::class, QualityRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
