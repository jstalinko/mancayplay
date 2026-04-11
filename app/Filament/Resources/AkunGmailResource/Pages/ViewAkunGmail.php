<?php

namespace App\Filament\Resources\AkunGmailResource\Pages;

use App\Filament\Resources\AkunGmailResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAkunGmail extends ViewRecord
{
    protected static string $resource = AkunGmailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
