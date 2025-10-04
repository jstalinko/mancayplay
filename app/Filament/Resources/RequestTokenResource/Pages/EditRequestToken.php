<?php

namespace App\Filament\Resources\RequestTokenResource\Pages;

use App\Filament\Resources\RequestTokenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRequestToken extends EditRecord
{
    protected static string $resource = RequestTokenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
