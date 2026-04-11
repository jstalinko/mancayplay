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
                Order::query()->where('customer_email', auth()->user() ? auth()->user()->email : '')->orderBy('id','desc')
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
                
                Action::make('view_product')->label('Detail Produk')
                    ->icon('heroicon-o-information-circle')
                    ->color('success')
                    ->modalHeading('Konten Produk Anda')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->visible(fn (Order $record) => $record->status === 'PAID' && !empty($record->product_content))
                    ->form(function (Order $record) {
                        $content = trim($record->product_content);
                        
                        // Check if the content is a URL
                        $isUrl = filter_var($content, FILTER_VALIDATE_URL) !== false || preg_match('/^https?:\/\//i', $content);
                        
                        if ($isUrl) {
                            return [
                                \Filament\Forms\Components\Placeholder::make('product_link')
                                    ->label('Tautan Produk')
                                    ->content(new \Illuminate\Support\HtmlString('
                                        <div class="mt-2">
                                            <a href="' . htmlspecialchars($content, ENT_QUOTES) . '" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; border-radius: 0.5rem; background-color: rgb(79, 70, 229); padding: 0.5rem 1.5rem; text-sm; font-weight: 600; color: white; transition: background-color 0.2s;">
                                                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                                Buka / Download Tautan
                                            </a>
                                        </div>
                                    '))
                            ];
                        }

                        // If not a URL, show as a read-only textarea
                        return [
                            \Filament\Forms\Components\Textarea::make('product_content_text')
                                ->label('Informasi / Akun Produk Anda')
                                ->default($content)
                                ->disabled()
                                ->rows(8)
                                ->columnSpanFull()
                        ];
                    }),
                Action::make('minta_otp')
                    ->label('Minta OTP')
                    ->icon('heroicon-o-key')
                    ->color('primary')
                    ->url(fn (Order $record): string => url('/inbox/' . $record->product_id))
                    ->visible(fn (Order $record) => $record->product && $record->product->otp_feature && $record->status === 'PAID'),
            ]);
    }
}
