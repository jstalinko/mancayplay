<?php

namespace App\Filament\Resources\UserResource\Widgets;

use Filament\Widgets\Widget;

class UserCreatedNotification extends Widget
{
    protected static string $view = 'filament.resources.user-resource.widgets.user-created-notification';

    protected string|array|int $columnSpan = 'full';


    public bool $isVisible = false;

    // Properti untuk menampung data dari event
    public ?string $email = null;
    public ?string $password = null;

    public function mount(): void
    {
        // Cek apakah ada data di session flash
      //  dd(session('user_created_credentials'));
        if (session()->has('user_created_credentials')) {
            // Ambil datanya
            $credentials = session('user_created_credentials');
            $this->email = $credentials['email'];
            $this->password = $credentials['password'];

            session()->forget('user_created_credentials');
        }
    }

   
    public function isVisible(): bool
    {
        return !is_null($this->email) && !is_null($this->password);
    }
}
