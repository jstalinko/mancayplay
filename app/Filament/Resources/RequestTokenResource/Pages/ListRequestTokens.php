<?php

namespace App\Filament\Resources\RequestTokenResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RequestTokenResource;

class ListRequestTokens extends ListRecords
{
    protected static string $resource = RequestTokenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
     protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();

        if (!Auth::user()->hasRole('super_admin')) {
            $query->where('user_id', Auth::id());
        }

        return $query;
    }
}
