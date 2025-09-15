<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;

class Setting extends Page implements HasForms
{
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth'; // Ikon diubah agar lebih sesuai

    protected static string $view = 'filament.pages.setting';

    protected static ?string $navigationGroup = 'Administrator Menu';
    protected static ?int $navigationSort = 5;

    public ?array $data = []; // Diubah menjadi public ?array

    public function mount(): void
    {
        // Tidak perlu memuat data dua kali, form->fill sudah cukup
        $this->form->fill($this->loadSettings());
    }

    protected function loadSettings(): array
    {
        if (!Storage::exists('settings.json')) {
            return [];
        }
        $settings = Storage::get('settings.json'); // storage/app/settings.json  
        return json_decode($settings, true) ?? [];
    }

    protected function saveSettings(array $data): void
    {
        $settings = json_encode($data, JSON_PRETTY_PRINT);
        Storage::put('settings.json', $settings);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('FC 2025 Settings')
                ->description('Atur semua tautan yang berhubungan dengan FC 2025.')
                ->schema([
                    // Gunakan prefix 'fc2025_' untuk membedakan data di file JSON
                    TextInput::make('fc2025_download_link')
                        ->label('Download Link')
                        ->placeholder('https://www.mediafire.com/...')
                        ->url() // Validasi URL
                        ->required(),
                    TextInput::make('fc2025_discord_link')
                        ->label('Discord Link')
                        ->placeholder('https://discord.gg/...')
                        ->url()
                        ->required(),
                    TextInput::make('fc2025_whatsapp_link')
                        ->label('Whatsapp Link')
                        ->placeholder('https://wa.me/62...')
                        ->url()
                        ->required(),
                    TextInput::make('fc2025_title_update_link')
                        ->label('Title Update Link')
                        ->placeholder('https://www.mediafire.com/...')
                        ->url()
                        ->required(),
                ])->columns(2), // Membuat layout form menjadi 2 kolom

            Section::make('FC 2026 Settings')
                ->description('Atur semua tautan yang berhubungan dengan FC 2026.')
                ->schema([
                    // Gunakan prefix 'fc2026_'
                    TextInput::make('fc2026_download_link')
                        ->label('Download Link')
                        ->placeholder('https://www.mediafire.com/...')
                        ->url()
                        ->required(),
                    TextInput::make('fc2026_discord_link')
                        ->label('Discord Link')
                        ->placeholder('https://discord.gg/...')
                        ->url()
                        ->required(),
                    TextInput::make('fc2026_whatsapp_link')
                        ->label('Whatsapp Link')
                        ->placeholder('https://wa.me/62...')
                        ->url()
                        ->required(),
                    TextInput::make('fc2026_title_update_link')
                        ->label('Title Update Link')
                        ->placeholder('https://www.mediafire.com/...')
                        ->url()
                        ->required(),
                ])->columns(2),

        ])->statePath('data');
    }

    // Menambahkan tombol Simpan di header halaman
    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Changes')
                ->submit('submit') // Memanggil method submit() saat diklik
                ->keyBindings(['mod+s']), // Shortcut keyboard (Ctrl+S or Cmd+S)
        ];
    }

    public function submit()
    {
        $data = $this->form->getState(); // Cukup panggil getState() tanpa parameter
        $this->saveSettings($data);

        Notification::make()
            ->title('Settings saved successfully')
            ->icon('heroicon-o-check-circle')
            ->success()
            ->send();
    }
}
