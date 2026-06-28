<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Filament\Facades\Filament;
use Filament\Support\Facades\FilamentColor;

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
        Paginator::useBootstrapFive();

        // Filament components (forms/actions) embedded in non-panel Blade pages
        // (e.g. the Sneat-themed views) never go through Filament's panel
        // middleware, so Panel::boot() never runs and FilamentColor::register()
        // never receives AppPanelProvider's colors — it falls back to Filament's
        // stock defaults instead. Register the "app" panel's colors directly so
        // those pages get the same palette; actual /app panel requests still
        // re-register correctly via Filament's own middleware regardless.
        $this->app->booted(function () {
            if (Filament::getCurrentPanel() === null) {
                $panel = Filament::getPanel('app');
                Filament::setCurrentPanel($panel);
                FilamentColor::register($panel->getColors());
            }
        });
    }


}
