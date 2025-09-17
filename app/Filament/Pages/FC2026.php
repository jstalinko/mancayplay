<?php

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Pages\Page;

class FC2026 extends Page
{
    protected static ?string $navigationIcon = 'heroicon-m-play';

    protected static string $view = 'filament.pages.f-c2026';

    protected static ?string $navigationLabel = 'FC 2026';

    protected static ?string $title = 'FC 2026';


    use HasPageShield;
}
