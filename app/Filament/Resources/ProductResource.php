<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    use HasPanelShield;
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Administrator Menu';

    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('General Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                        Forms\Components\TextInput::make('category'),
                        Forms\Components\TextInput::make('link')
                            ->required()->url()->columnSpanFull(),
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\TextInput::make('price')
                            ->prefix('Rp')
                            ->numeric(),
                        Forms\Components\RichEditor::make('short_description')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Product Content')
                    ->schema([
                        Forms\Components\Select::make('product_type')
                            ->options([
                                'text' => 'Text',
                                'file' => 'File',
                            ])
                            ->required()
                            ->live(),
                        Forms\Components\Textarea::make('product_content')
                            ->label('Product Content (Text)')
                            ->visible(fn (Forms\Get $get) => $get('product_type') === 'text')
                            ->required(fn (Forms\Get $get) => $get('product_type') === 'text')
                            ->columnSpanFull()->helperText('Jika produk massal pisahkan dengan new-line'),
                        Forms\Components\FileUpload::make('product_content')
                            ->label('Product Content (File)')
                            ->visible(fn (Forms\Get $get) => $get('product_type') === 'file')
                            ->required(fn (Forms\Get $get) => $get('product_type') === 'file')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\Toggle::make('active')
                            ->required(),
                        Forms\Components\Toggle::make('remove_product_after_sale')
                            ->required()->helperText('Hapus akun / produk setelah di beli pelanggan. pisahkan dengan newline / enter bawah'),
                    ])->columns(2),

                Forms\Components\Section::make('Advanced Configuration')
                    ->description('Enable OTP and assign associated accounts.')
                    ->schema([
                        Forms\Components\Toggle::make('otp_feature')
                            ->default(false)
                            ->live(),
                        Forms\Components\Select::make('akun_gmail_id')
                            ->label('Akun Gmail')
                            ->options(fn() => \App\Models\AkunGmail::all()->mapWithKeys(fn($akun) => [$akun->id => "{$akun->name} - {$akun->email}"]))
                            ->required(fn(Forms\Get $get) => $get('otp_feature'))
                            ->visible(fn(Forms\Get $get) => $get('otp_feature')),
                        Forms\Components\TextInput::make('get_only_subject')->label('Hanya Ambil Email dengan judul ini:')
                            ->visible(fn(Forms\Get $get) => $get('otp_feature'))->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')->money('IDR'),
                Tables\Columns\IconColumn::make('otp_feature')
                    ->boolean(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\ToggleColumn::make('active')
                    ,
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
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
