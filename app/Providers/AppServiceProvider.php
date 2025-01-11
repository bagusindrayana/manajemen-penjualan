<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;

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
        // Filament::serving(function () {
        //     Filament::registerNavigationItems([
        //         NavigationItem::make('Dashboard')
        //     ]);
        // });

        // Filament::serving(function () {
        //     Filament::registerNavigationItems([
        //         NavigationItem::make('Analytics')
        //             ->url('https://filament.pirsch.io', shouldOpenInNewTab: true)
        //             ->icon('heroicon-o-presentation-chart-line')
        //             ->activeIcon('heroicon-s-presentation-chart-line')
        //             ->sort(3),
        //     ]);
        // });
    }
}
