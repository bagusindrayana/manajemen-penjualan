<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Filament\Support\Colors\Color;
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

        // FilamentColor::register([
        //     'danger' => Color::Red,
        //     'gray' => Color::Zinc,
        //     'info' => Color::Blue,
        //     'primary' => Color::Amber,
        //     'success' => Color::Green,
        //     'warning' => Color::Amber,
        // ]);

        // FilamentColor::register([
        //     'danger' => [
        //         50 => '254, 242, 242',
        //         100 => '254, 226, 226',
        //         200 => '254, 202, 202',
        //         300 => '252, 165, 165',
        //         400 => '248, 113, 113',
        //         500 => '239, 68, 68',
        //         600 => '220, 38, 38',
        //         700 => '185, 28, 28',
        //         800 => '153, 27, 27',
        //         900 => '127, 29, 29',
        //         950 => '69, 10, 10',
        //     ],
        // ]);
    }
}
