<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditSale extends EditRecord
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print')
                ->label('Print')
                ->url(fn () => route('print-invoice', $this->record->id))
                ->icon('heroicon-o-printer')
                ->color('info')
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
            
        ];
    }

}
