<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Filament\Resources\SaleResource\RelationManagers;
use App\Models\Product;
use App\Models\Sale;
use Exception;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('invoice_number')
                            ->default('INV-' . strtoupper(Str::random(8)))
                            ->required()
                            ->readOnly(),
                        Forms\Components\DateTimePicker::make('date')
                            ->required()
                            ->default(now()),
                        Forms\Components\Select::make('payment_method')
                            ->options([
                                'cash' => 'Tunai',
                                'transfer' => 'Transfer Bank',
                                'qris' => 'QRIS',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('notes')
                            ->rows(3),
                        Forms\Components\Hidden::make('total_amount'),
                    ])->columnSpan(['lg' => 1]),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->relationship()
                            ->live()
                            ->afterStateUpdated(function (callable $set, callable $get) {
                                $total = collect($get('items'))
                                    ->sum(function ($item) {
                                        return $item['subtotal'] ?? 0;
                                    });
                                // calculate sum
                                $set('total_amount', $total);
                            })
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->label('Produk')
                                    // ->options(Product::query()->pluck('name', 'id'))
                                    ->required()
                                    ->searchable()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state) {
                                            $product = Product::find($state);
                                            $set('max_qty',$product->stock);
                                            if($product->stock <= 0){
                                                Notification::make()
                                                ->title('Stok produk tidak cukup')
                                                ->warning()
                                                ->send();
                                            } else {
                                                $set('price', $product->selling_price);
                                                $set('subtotal', $product->selling_price);
                                                $set('total_amount', $product->selling_price);
                                            }
                                            
                                        }
                                    })
                                    ->getSearchResultsUsing(function (string $search): array {
                                        return Product::query()
                                            ->where(function (Builder $builder) use ($search) {
                                                $searchString = "%$search%";
                                                $builder->where('name', 'like', $searchString);
                                            })
                                            ->where('stock','>',0)
                                            ->limit(50)
                                            ->get()
                                            ->mapWithKeys(function (Product $product) {
                                                return [$product->id => $product->name];
                                            })
                                            ->toArray();
                                    }),
                                Forms\Components\TextInput::make('quantity')
                                    ->numeric()
                                    ->default(1)
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        if ($state && $get('price')) {
                                            $set('subtotal', $state * $get('price'));
                                            $total = collect($get('items'))->values()->pluck('subtotal')->sum();
                                            $set('total_amount', $total);
                                        }
                                    })->maxValue(function (callable $get): int {
                                        return (int) $get('max_qty');
                                    }),
                                    
                                Forms\Components\TextInput::make('price')
                                    ->label('Harga')
                                    ->readOnly()
                                    ->numeric()
                                    ->required()
                                    ->prefix('Rp'),
                                Forms\Components\TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->readOnly()
                                    ->numeric()
                                    ->required()
                                    ->prefix('Rp'),
                            ])
                            ->defaultItems(1)
                            ->columns(4)
                            ->addACtionLabel('Tambah Produk')
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                $product = Product::findOrFail($data['product_id']);
                                $product->update([
                                    'stock' => $product->stock - $data['quantity']
                                ]);
                                
                                return $data;
                            })
                            ->addAction(function (callable $get, callable $set) {
                                $total = collect($get('items'))->values()->pluck('subtotal')->sum();
                                $set('total_amount', $total);
                            }),
                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('total')
                            ->label('Total Pembayaran')
                            ->content(function ($get) {
                                $total = collect($get('items'))
                                    ->sum(function ($item) {
                                        return $item['subtotal'] ?? 0;
                                    });
                                return 'Rp ' . number_format($total, 0, ',', '.');
                            }),
                    ])->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('No. Invoice')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('items_count')
                    ->label('Jumlah Item')
                    ->counts('items'),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('idr')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Pembayaran'),
            ])
            ->filters([
                DateRangeFilter::make('date'),
            ])
            ->actions([
                Action::make('print')
                ->url(fn ($record) => route('print-invoice', $record->id))
                ->openUrlInNewTab()
                ->icon('heroicon-o-printer')
                ->color('info'),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
