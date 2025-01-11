<?php

namespace App\Filament\Resources\SaleResource\Widgets;

use App\Models\Sale;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalesOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $today = now();
        $todaySales = Sale::whereDate('date', $today)->sum('total_amount');
        $yesterdaySales = Sale::whereDate('date', $today->copy()->subDay())->sum('total_amount');
        $thisMonthSales = Sale::whereMonth('date', $today->month)->sum('total_amount');

        return [
            Stat::make('Penjualan Hari Ini', 'Rp ' . number_format($todaySales, 0, ',', '.'))
                ->description('Total penjualan hari ini')
                ->descriptionIcon('heroicon-s-currency-dollar')
                ->chart([7, 4, 6, 8, 5, 3, 7]),

            Stat::make('Penjualan Kemarin', 'Rp ' . number_format($yesterdaySales, 0, ',', '.'))
                ->description('Total penjualan kemarin')
                ->descriptionIcon('heroicon-s-currency-dollar')
                ->chart([3, 5, 7, 4, 6, 3, 4]),

            Stat::make('Penjualan Bulan Ini', 'Rp ' . number_format($thisMonthSales, 0, ',', '.'))
                ->description('Total penjualan bulan ini')
                ->descriptionIcon('heroicon-s-currency-dollar')
                ->chart([8, 6, 4, 7, 5, 8, 9]),
        ];
    }

}
