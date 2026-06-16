<?php

namespace App\Providers;

use App\Models\Repositories\ProductRepository;
use App\Models\Repositories\ProductAnalyticsRepository;
use App\Models\Repositories\SalesRepository;
use App\Models\Repositories\CategoryRepository;
use App\Models\Repositories\BrandRepository;
use App\Models\Repositories\UnitOfMeasureRepository;
use App\Models\Repositories\CustomerRepository;
use App\Services\ProductCRUDService;
use App\Services\SaleCRUDService;
use App\Services\CategoryCRUDService;
use App\Services\BrandCRUDService;
use App\Services\UnitOfMeasureCRUDService;
use App\Services\CustomerCRUDService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductRepository::class);
        $this->app->bind(ProductAnalyticsRepository::class);
        $this->app->bind(SalesRepository::class);
        $this->app->bind(ProductCRUDService::class);
        $this->app->bind(SaleCRUDService::class);
        $this->app->bind(CategoryRepository::class);
        $this->app->bind(CategoryCRUDService::class);
        $this->app->bind(BrandRepository::class);
        $this->app->bind(BrandCRUDService::class);
        $this->app->bind(UnitOfMeasureRepository::class);
        $this->app->bind(UnitOfMeasureCRUDService::class);
        $this->app->bind(CustomerRepository::class);
        $this->app->bind(CustomerCRUDService::class);
    }

    public function boot(): void
    {
        //
    }
}
