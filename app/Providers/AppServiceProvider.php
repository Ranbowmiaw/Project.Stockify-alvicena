<?php

namespace App\Providers;


use illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockOpname;
use App\Models\suppliers;
use App\Models\StockTransaction;
use App\Observers\CategoryObserver;
use App\Observers\ProductObserver;
use App\Observers\StockOpnameObserver;
use App\Observers\StockSettingObserver;
use App\Observers\SupplierObserver;
use App\Observers\StockTransactionObserver;
use App\Repositories\CategoryRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\SupplierRepositoryInterface;
use App\Repositories\ProductAttributeRepository;
use App\Repositories\ProductRepository;
use App\Repositories\StockTransactionRepository;
use App\Repositories\SupplierRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(SupplierRepositoryInterface::class, SupplierRepository::class);
        $this->app->bind(ProductAttributeRepository::class);
        $this->app->bind(StockTransactionRepository::class);


        $this->app->bind(
            \App\Services\Interfaces\StockServiceInterface::class,
            \App\Services\StockService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {   
        config(['app.locale' => 'id']);
        Carbon::setlocale('id');
        date_default_timezone_set('Asia/Jakarta');


        Category::observe(CategoryObserver::class);
        Product::observe(ProductObserver::class);
        suppliers::observe(SupplierObserver::class);
        StockTransaction::observe(StockTransactionObserver::class);
        StockOpname::observe(StockOpnameObserver::class);
        Product::observe(StockSettingObserver::class);
    }



    
}
