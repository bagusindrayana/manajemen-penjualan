<?php
namespace App\Filament\Pages;

use App\Filament\Resources\SaleResource\Widgets\SalesOverview;
use App\Filament\Resources\SaleResource\Widgets\SalesChart;
use App\Filament\Resources\SaleResource\Widgets\TopProduct;
use App\Filament\Resources\SaleResource\Widgets\DailySalesChart;
use Filament\Widgets;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            SalesOverview::class,
            SalesChart::class,
            TopProduct::class,
            DailySalesChart::class,
        ];
    }
}