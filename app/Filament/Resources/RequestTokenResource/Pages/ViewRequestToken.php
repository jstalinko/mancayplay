<?php

namespace App\Filament\Resources\RequestTokenResource\Pages;

use App\Filament\Resources\RequestTokenResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRequestToken extends ViewRecord
{
    protected static string $resource = RequestTokenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
