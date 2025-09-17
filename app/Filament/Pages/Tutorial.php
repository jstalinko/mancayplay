<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Collection;
use App\Models\Tutorial as TutorialModel;
use App\Filament\Resources\TutorialResource;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class Tutorial extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static string $view = 'filament.pages.tutorial';




     // Properti untuk menampung data tutorial
    public Collection $tutorials;

    // Method mount() dieksekusi saat halaman dimuat
    public function mount(): void
    {
        // Ambil semua data tutorial, urutkan dari yang terbaru
        $this->tutorials = TutorialModel::latest()->get();
    }
}
