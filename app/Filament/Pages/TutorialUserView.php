<?php

namespace App\Filament\Pages;

use App\Models\Tutorial; // 1. Import your Tutorial model
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class TutorialUserView extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.tutorial-user-view';

    protected static bool $shouldRegisterNavigation = false;

    // 2. Change the route to accept a parameter
    protected static ?string $routePath = '/tutorial-user-view/{record}';
    
    // 3. Add a public property to hold the Tutorial data
    public Tutorial $record;

    // 4. (Optional) Make the page title dynamic
    public function getTitle(): string | Htmlable
    {
        return $this->record->title;
    }

    public function mount()
    {
        $this->record = Tutorial::find($_GET['record']);
    }
}