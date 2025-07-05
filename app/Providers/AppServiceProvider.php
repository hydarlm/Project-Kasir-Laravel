<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

use App\View\Components\InputField;
use App\View\Components\FormLabel;
use App\View\Components\ButtonPrimary;
use App\View\Components\ButtonSecondary;
use App\View\Components\Modal;
use App\View\Components\DataTable;

class AppServiceProvider extends ServiceProvider
{
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
        Blade::component('input-field', InputField::class);
        Blade::component('form-label', FormLabel::class);
        Blade::component('button-primary', ButtonPrimary::class);
        Blade::component('button-secondary', ButtonSecondary::class);
        Blade::component('modal', Modal::class);
        Blade::component('data-table', DataTable::class);
    }
}
