<?php

namespace App\Filament\Resources\SaleReportResource\Pages;

use App\Filament\Resources\SaleReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSaleReport extends ViewRecord
{
    protected static string $resource = SaleReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
