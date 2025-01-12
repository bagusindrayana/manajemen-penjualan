<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535),
                Forms\Components\TextInput::make('stock')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('purchase_price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\TextInput::make('selling_price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\Select::make('category')
                    ->required()
                    ->options([
                        'electronics' => 'Elektronik',
                        'fashion' => 'Fashion',
                        'food' => 'Makanan',
                        'others' => 'Lainnya',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock')
                    ->sortable(),
                Tables\Columns\TextColumn::make('purchase_price')
                    ->money('idr')
                    ->sortable(),
                Tables\Columns\TextColumn::make('selling_price')
                    ->money('idr')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'electronics' => 'Elektronik',
                        'fashion' => 'Fashion',
                        'food' => 'Makanan',
                        'others' => 'Lainnya',
                    ]),
            ])->actions(Auth::user() != null && Auth::user()->role=="admin" ? [
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->action(function ($record) {
                    try {
                        // Attempt to delete the record
                        DB::transaction(function () use ($record) {
                            $record->delete();
                        });

                        // Show success notification
                        Notification::make()
                                    ->title('Record deleted successfully')
                                    ->success()
                                    ->send();
                    } catch (\Exception $e) {
                        // Log the error or handle it as needed
                        logger()->error($e->getMessage());

                        Notification::make()
                                    ->title('Failed to delete the record. Please try again')
                                    ->danger()
                                    ->send();

                    }
                }),
            ] : [Tables\Actions\ViewAction::make()]);
    }

    public static function getRelations(): array
    {
        return [
            
        ];
    }

    public static function canCreate(): bool
    {
        return Auth::user()->role=="admin";
    }


    public static function canEdit(Model $record): bool
    {
        return Auth::user()->role=="admin";
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()->role=="admin";
    }

    

    public static function getPages(): array
    {   
        
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
        
    }
}
