<?php

namespace App\Filament\Resources\SaleResource\Pages;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\SaleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSale extends CreateRecord
{
    protected static string $resource = SaleResource::class;

    // protected function handleRecordCreation(array $data): Model
    // {   
    //     return static::getModel()::create($data);
    // }
}
