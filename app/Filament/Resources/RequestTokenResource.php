<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestTokenResource\Pages;
use App\Filament\Resources\RequestTokenResource\RelationManagers;
use App\Models\RequestToken;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RequestTokenResource extends Resource
{
    protected static ?string $model = RequestToken::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return false;
    }
    public static function canEdit(Model $record): bool
    {
        if(auth()->user()->hasRole('super_admin'))
        {
            return true;
        }else{
            return false;
        }
    }
    public static function canView(Model $record): bool
    {
        if(auth()->user()->hasRole('super_admin'))
        {
            return true;
        }else{
            return false;
        }
    }
    public static function canDelete(Model $record): bool
    {
        if(auth()->user()->hasRole('super_admin'))
        {
            return true;
        }else{
            return false;
        }
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->required()
                    ->relationship('user','name'),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'rejected' => 'REJECT / TOLAK',
                        'approved' => 'APPROVE / TERIMA',
                        'pending' => 'PENDING'
                    ]),
                Forms\Components\Textarea::make('token')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('type')
                    ->required()
                    ->options(
                        [
                            'fc2025' => 'FC2025',
                            'fc2026' => 'FC2026'
                        ]
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
      

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('token')->copyable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->badge()
                    ->color(fn($state) => match($state) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'pending' => 'warning'
                    }),
                Tables\Columns\TextColumn::make('type')
                    ->searchable()->label('Tipe Token'),
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
            'index' => Pages\ListRequestTokens::route('/'),
            'create' => Pages\CreateRequestToken::route('/create'),
            'view' => Pages\ViewRequestToken::route('/{record}'),
            'edit' => Pages\EditRequestToken::route('/{record}/edit'),
        ];
    }
}
