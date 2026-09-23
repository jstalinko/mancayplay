<?php

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Pages\Page;

class FC2027 extends Page
{
    protected static ?string $navigationIcon = 'heroicon-m-play';

    protected static string $view = 'filament.pages.f-c2027';

    protected static ?string $navigationLabel = 'FC 2027';

    protected static ?string $title = 'FC 2027';

    use HasPageShield;
}
