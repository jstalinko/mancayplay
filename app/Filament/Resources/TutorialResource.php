<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Tutorial;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TutorialResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use App\Filament\Resources\TutorialResource\RelationManagers;

class TutorialResource extends Resource
{
    use HasPanelShield;
    protected static ?string $model = Tutorial::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Administrator Menu';

    public static function canAccess(): bool
    {
        if(!auth()->user()->hasRole('super_admin'))
        {
            return false;
        }
        return true;
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('embed_youtube')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
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
            'index' => Pages\ListTutorials::route('/'),
            'create' => Pages\CreateTutorial::route('/create'),
            'view' => Pages\ViewTutorial::route('/{record}'),
            'edit' => Pages\EditTutorial::route('/{record}/edit'),
        ];
    }
}
