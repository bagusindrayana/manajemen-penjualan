<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class SalesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithCalculatedFormulas
{
    protected $startDate;
    protected $endDate;

    private $total = 0;

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
        $total = 0;
        foreach ($sale->items as $item) {
            $total += $item->subtotal;
            $rows[] = [
                $sale->date->format('d/m/Y H:i'),
                $sale->invoice_number,
                $item->product->name,
                $item->quantity,
                $item->price,
                $item->subtotal,
                $total,
            ];
            $this->total += $item->subtotal;
        }
        return $rows;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // $cellRange = 'F2:F' . ($event->sheet->getHighestRow() - 1);
                // $event->sheet->setCellValue('F' . $event->sheet->getHighestRow()+1, '=SUM(' . $cellRange . ')');
                // $cellRange = 'G2:G' . ($event->sheet->getHighestRow() - 1);
                // $event->sheet->setCellValue('G' . $event->sheet->getHighestRow(), '=SUM(' . $cellRange . ')');
                $event->sheet->setCellValue('A' . $event->sheet->getHighestRow()+1, "Total");
                $event->sheet->setCellValue('G' . $event->sheet->getHighestRow(), $this->total);
            },
        ];
    }
}
