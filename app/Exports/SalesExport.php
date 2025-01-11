<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SalesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {   

        return Sale::query()
            ->with(['items.product'])
            ->whereBetween('date', [$this->startDate." 00:00:00", $this->endDate." 23:59:59"])
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'No Invoice',
            'Produk',
            'Qty',
            'Harga Satuan',
            'Subtotal',
            'Total Pembayaran',
            'Metode Pembayaran',
        ];
    }

    public function map($sale): array
    {
        $rows = [];
        foreach ($sale->items as $item) {
            $rows[] = [
                $sale->date->format('d/m/Y H:i'),
                $sale->invoice_number,
                $item->product->name,
                $item->quantity,
                $item->price,
                $item->subtotal,
                $sale->total_amount,
                $sale->payment_method,
            ];
        }
        return $rows;
    }
}
