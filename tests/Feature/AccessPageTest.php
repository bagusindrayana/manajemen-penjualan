<?php
use App\Filament\Resources\ProductResource;
use App\Filament\Resources\SaleReportResource;
use App\Filament\Resources\SaleResource;
use App\Filament\Resources\UserResource;

it('can render page product', function () {
    $this->get(ProductResource::getUrl('index'))->assertSuccessful();
});

it('can render page sale', function () {
    $this->get(SaleResource::getUrl('index'))->assertSuccessful();
});

it('can render page user', function () {
    $this->get(UserResource::getUrl('index'))->assertSuccessful();
});

it('can render page sale report', function () {
    $this->get(SaleReportResource::getUrl('index'))->assertSuccessful();
});