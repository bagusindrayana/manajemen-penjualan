<?php

namespace App\Filament\Resources\SaleResource\Widgets;

use App\Models\Sale;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class DailySalesChart extends ChartWidget
{
    protected static ?string $heading = 'Penjualan per Hari';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = Sale::query()
            ->select(DB::raw('DATE(date) as sale_date'), DB::raw('SUM(total_amount) as total_sales'))
            ->whereDate('date', '>=', now()->subDays(7))
            ->groupBy('sale_date')
            ->orderBy('sale_date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total Penjualan',
                    'data' => $data->pluck('total_sales')->toArray(),
                ]
            ],
            'labels' => $data->pluck('sale_date')->map(function ($date) {
                return date('d M', strtotime($date));
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
