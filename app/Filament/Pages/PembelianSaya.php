<?php

namespace App\Filament\Pages;

use App\Models\Order;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;

class PembelianSaya extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.pembelian-saya';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()->where('customer_email', auth()->user() ? auth()->user()->email : '')
            )
            ->columns([
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'UNPAID' => 'warning',
                        'PAID' => 'success',
                        'WAITING_CONFIRMATION' => 'info',
                        'EXPIRED' => 'danger',
                        'CANCELED' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('invoice')
                    ->searchable(),
                TextColumn::make('product.name')
                    ->label('Product Name'),
                TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Date'),
                TextColumn::make('notes')
                    ->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make('payment_proof')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Action::make('minta_otp')
                    ->label('Minta OTP')
                    ->icon('heroicon-o-key')
                    ->color('primary')
                    ->url(fn (Order $record): string => url('/inbox/' . $record->product_id))
                    ->visible(fn (Order $record) => $record->product && $record->product->otp_feature && $record->status === 'PAID'),
            ]);
    }
}
