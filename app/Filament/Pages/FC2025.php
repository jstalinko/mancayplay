<?php

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Pages\Page;

class FC2025 extends Page
{
    protected static ?string $navigationIcon = 'heroicon-m-play';

    protected static ?string $navigationLabel = 'FC 2025';
    protected static ?string $title = 'FC 2025';

    protected static string $view = 'filament.pages.f-c2025';

    use HasPageShield;
}
