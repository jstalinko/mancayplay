<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Administrator Menu';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('invoice')
                    ->required(),
                Forms\Components\TextInput::make('reference'),
                Forms\Components\TextInput::make('product_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('order_type')
                    ->required(),
                Forms\Components\TextInput::make('customer_name')
                    ->required(),
                Forms\Components\TextInput::make('customer_email')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('customer_phone')
                    ->tel()
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\TextInput::make('payment_proof'),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('status')->badge()->color(fn($state) => match($state)
                {
                    'UNPAID' => 'warning',
                    'PAID' => 'success',
                    'WAITING_CONFIRMATION' => 'info',
                    'EXPIRED' => 'danger',
                    'CANCELED' => 'danger'
                }),
                   Tables\Columns\TextColumn::make('order_type')
                    ->searchable()->badge()->color(fn($state) => match($state){
                        'whatsapp' => 'success',
                        'web' => 'info',
                        'lynkid' => 'primary',
                        'shopee' => 'warning'
                    }),
                Tables\Columns\TextColumn::make('invoice')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reference')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->numeric()
                    ->sortable(),
             
                Tables\Columns\TextColumn::make('customer_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money(currency:'IDR')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('payment_proof'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'PAID' => 'PAID',
                        'UNPAID' => 'UNPAID',
                        'WAITING_CONFIRMATION' => 'WAITING_CONFIRMATION',
                        'EXPIRED' => 'EXPIRED',
                        'CANCELED' => 'CANCELED',
                    ]),
                Tables\Filters\SelectFilter::make('order_type')
                    ->options([
                        'web' => 'Web',
                        'whatsapp' => 'WhatsApp',
                        'shopee' => 'Shopee',
                        'lynkid' => 'Lynk.id',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('mark_as_paid')->icon('heroicon-o-check-circle')->color('success')->visible(fn($record) => $record->status == 'WAITING_CONFIRMATION')->action(function($record){
                    $product = \App\Models\Product::find($record->product_id);
                    $record->update([
                        'product_content' => $product->getProductContent(),
                        'status'=> 'PAID',
                        'notes' => 'Order confirmed by admin at '.date('D,d-m-Y H:i'),
                    ]);
                    $userRegistered = \App\Models\User::where('email' , $record->customer_email)->first();
                
                    if($userRegistered)
                    {
                        $message = "Halo Kak *" . $userRegistered->name . "*\n\nTerima kasih sudah order di MancayPlay! Pesanan Kakak sudah berhasil di konfirmasi.\n\nBerikut adalah detail pesanan Kakak:\n\n*Invoice*: " . $record->invoice . "\n*Produk*: " . $record->product->name . "\n*Harga*: Rp " . number_format($record->price, 0, ',', '.') . "\n*Status*: PAID\n\nSilahkan login ke mancayplay.com/dashboard  untuk mendapatkan akses ke produk yang sudah dibeli.\n\nJika ada pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami.\n\nTerima kasih!\n\nSalam hangat,\n*MancayPlay*";
                    }else{
                        
                        \App\Models\User::create([
                            'name' => $record->customer_name,
                            'email' => $record->customer_email,
                            'password' => Hash::make($record->customer_phone),
                        ]);
                        $message = "Halo Kak *" . $record->customer_name . "*\n\nTerima kasih sudah order di MancayPlay! Pesanan Kakak sudah berhasil di konfirmasi.\n\nBerikut adalah detail pesanan Kakak:\n\n*Invoice*: " . $record->invoice . "\n*Produk*: " . $record->product->name . "\n*Harga*: Rp " . number_format($record->price, 0, ',', '.') . "\n*Status*: PAID\n\n";
                        $message.= "Detail login member mancayplay.com: \n\n";
                        $message.= "Email: ".$record->customer_email."\n";
                        $message.= "Password: ".$record->customer_phone."\n";
                        $message.= "*NB: Setelah login silahkan ganti password anda!!*";
                    }
                    \App\Helper::send_whatsapp($message , $record->customer_phone);

                }),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                Tables\Actions\BulkAction::make('mark_as_paid')->icon('heroicon-o-check-circle')->color('success')->action(function($records) {
                    foreach($records as $record) {
                        $product = \App\Models\Product::find($record->product_id);
                        $record->update([
                            'product_content' => $product->getProductContent(),
                            'status'=> 'PAID',
                            'notes' => 'Order confirmed by admin at '.date('D,d-m-Y H:i'),
                        ]);
                        
                        $userRegistered = \App\Models\User::where('email' , $record->customer_email)->first();
                        if($userRegistered)
                        {
                            $message = "Halo Kak *" . $userRegistered->name . "*\n\nTerima kasih sudah order di MancayPlay! Pesanan Kakak sudah berhasil di konfirmasi.\n\nBerikut adalah detail pesanan Kakak:\n\n*Invoice*: " . $record->invoice . "\n*Produk*: " . $record->product->name . "\n*Harga*: Rp " . number_format($record->price, 0, ',', '.') . "\n*Status*: PAID\n\nSilahkan login ke mancayplay.com/dashboard  untuk mendapatkan akses ke produk yang sudah dibeli.\n\nJika ada pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami.\n\nTerima kasih!\n\nSalam hangat,\n*MancayPlay*";
                        } else {
                            \App\Models\User::create([
                                'name' => $record->customer_name,
                                'email' => $record->customer_email,
                                'password' => Hash::make($record->customer_phone),
                            ]);
                            $message = "Halo Kak *" . $record->customer_name . "*\n\nTerima kasih sudah order di MancayPlay! Pesanan Kakak sudah berhasil di konfirmasi.\n\nBerikut adalah detail pesanan Kakak:\n\n*Invoice*: " . $record->invoice . "\n*Produk*: " . $record->product->name . "\n*Harga*: Rp " . number_format($record->price, 0, ',', '.') . "\n*Status*: PAID\n\n";
                            $message.= "Detail login member mancayplay.com: \n\n";
                            $message.= "Email: ".$record->customer_email."\n";
                            $message.= "Password: ".$record->customer_phone."\n";
                            $message.= "*NB: Setelah login silahkan ganti password anda!!*";
                        }
                        \App\Helper::send_whatsapp($message,$record->customer_phone);
                        usleep(500000); // 500ms delay (using 500000 microseconds for 0.5s)
                    }
                })->requiresConfirmation()->deselectRecordsAfterCompletion()

                ])
            ->defaultSort('id', 'desc');
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
