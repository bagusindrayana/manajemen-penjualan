<?php

namespace App\Filament\Resources;

use App\Exports\SalesExport;
use App\Filament\Resources\SaleReportResource\Pages;
use App\Filament\Resources\SaleReportResource\RelationManagers;
use App\Models\Sale;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SaleReportResource extends Resource
{
    protected static ?string $model = Sale::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-down';
    protected static ?string $navigationLabel = 'Sales Report';
    protected static ?string $slug = 'sales-report';
    protected static ?int $navigationSort = 3;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('No Invoice')
                    ->searchable(),
                Tables\Columns\TextColumn::make('items.product.name')
                    ->label('Produk'),
                Tables\Columns\TextColumn::make('items.quantity')
                    ->label('Qty'),
                Tables\Columns\TextColumn::make('items.price')
                    ->label('Harga')
                    ->money('idr'),
                Tables\Columns\TextColumn::make('items.subtotal')
                    ->label('Subtotal')
                    ->money('idr'),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('idr')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Pembayaran'),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('date_from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('date_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['date_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    })
            ])
            ->actions([])
            ->bulkActions([])
            ->headerActions([
                Tables\Actions\Action::make('export')
                    ->label('Export Excel')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-on-square-stack')
                    ->action(function ($action) {
                        $table = $action->getLivewire()->getTable();
                        $filterData = $table->getFilter('created_at')->getState();
                        
                        $startDate = $filterData['date_from'] ?? now()->subMonth();
                        $endDate = $filterData['date_until'] ?? now();

                        return Excel::download(
                            new SalesExport($startDate, $endDate),
                            'laporan-penjualan-' . now()->format('Y-m-d') . '.xlsx'
                        );
                    })
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canViewAny(): bool
    {
        return Auth::user()->role=="admin";
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSaleReports::route('/'),
        ];
    }
}
