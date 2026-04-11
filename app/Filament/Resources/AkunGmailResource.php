<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AkunGmailResource\Pages;
use App\Filament\Resources\AkunGmailResource\RelationManagers;
use App\Models\AkunGmail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AkunGmailResource extends Resource
{
    protected static ?string $model = AkunGmail::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope-open';
    protected static ?string $navigationGroup = 'Administrator Menu';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('app_password')
                    ->password()
                    ->required(),
                Forms\Components\TextInput::make('imap_server')
                    ->required(),
                Forms\Components\TextInput::make('imap_port')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('imap_server')
                    ->searchable(),
                Tables\Columns\TextColumn::make('imap_port')
                    ->searchable(),
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
            'index' => Pages\ListAkunGmails::route('/'),
            'create' => Pages\CreateAkunGmail::route('/create'),
            'view' => Pages\ViewAkunGmail::route('/{record}'),
            'edit' => Pages\EditAkunGmail::route('/{record}/edit'),
        ];
    }
}
