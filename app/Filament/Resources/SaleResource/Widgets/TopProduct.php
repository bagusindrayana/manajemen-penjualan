<?php

namespace App\Filament\Resources\SaleResource\Widgets;

use App\Models\SaleItem;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TopProduct extends ChartWidget
{
    protected static ?string $heading = 'Produk Terlaris';

    protected function getData(): array
    {
        $data = SaleItem::query()
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('sum(quantity) as total_qty'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_qty', 'desc')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Terjual',
                    'data' => $data->pluck('total_qty')->toArray(),
                ]
            ],
            'labels' => $data->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
