<?php

namespace App\Filament\Resources\AkunGmailResource\Pages;

use App\Filament\Resources\AkunGmailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAkunGmail extends EditRecord
{
    protected static string $resource = AkunGmailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
