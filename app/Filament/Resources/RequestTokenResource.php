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
                Forms\Components\Textarea::make('user_token')
                ->columnSpanFull(),
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
                ->sortable(),

            Tables\Columns\TextColumn::make('token')
                ->copyable()
                ->sortable()
                ->formatStateUsing(fn($state) => substr($state, 0, 50) . '...'),

            Tables\Columns\TextColumn::make('status')
                ->searchable()
                ->badge()
                ->color(fn($state) => match ($state) {
                    'approved' => 'success',
                    'rejected' => 'danger',
                    'pending' => 'warning',
                })
                ->sortable(),

            Tables\Columns\TextColumn::make('type')
                ->searchable()
                ->label('Tipe Token')
                ->sortable(),

            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),

            // ✅ Copy User Token Action
            Tables\Actions\Action::make('copy_user_token')
                ->label('Copy Token')
                ->icon('heroicon-o-clipboard')
                ->color('warning')
                ->visible(fn() => auth()->user()->hasRole('super_admin'))
                ->action(function (Model $record, $livewire) {
                    $token = $record->user_token;

                    $livewire->js("navigator.clipboard.writeText('{$token}')");

                    \Filament\Notifications\Notification::make()
                        ->title('User Token copied to clipboard!')
                        ->success()
                        ->send();
                }),

            // ✅ Edit Token Action with Modal
            Tables\Actions\Action::make('edit_token')
                ->label('Input Token')
                ->icon('heroicon-o-pencil-square')
                ->color('success')
                ->visible(fn() => auth()->user()->hasRole('super_admin'))
                ->form([
                    Forms\Components\Textarea::make('token')
                        ->label('Token')
                        ->required()
                        ->rows(5),
                ])
                ->action(function (array $data, Model $record) {
                    $record->update([
                        'token' => $data['token'],
                    ]);

                    \Filament\Notifications\Notification::make()
                        ->title('Token successfully updated!')
                        ->success()
                        ->send();
                })
                ->modalHeading('Input Token')
                ->modalSubmitActionLabel('Save Changes')
                ->modalWidth('md'),
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
