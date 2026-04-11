<?php

namespace App\Filament\Resources\AkunGmailResource\Pages;

use App\Filament\Resources\AkunGmailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAkunGmails extends ListRecords
{
    protected static string $resource = AkunGmailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
