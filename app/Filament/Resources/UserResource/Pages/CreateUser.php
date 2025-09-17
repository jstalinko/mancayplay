<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Helper;
use Filament\Actions;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected string $plainPassword = '';
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $email = str_replace(' ','_',strtolower($data['name'])).time().'@mancayplay.com';
        $password = Helper::generatePassword();
        $this->plainPassword = $password;
        $data['email'] = $email;
        $data['password'] = bcrypt($password);
        $data['email_verified_at'] = now();

        return $data;
    }
  
    protected function afterCreate(): void
    {
        
        // Simpan data ke session flash
        session()->put('user_created_credentials', [
            'email' => $this->record->email,
            'password' => $this->plainPassword,
        ]);
    }

    /**
     * TAMBAHKAN METHOD INI
     * Method ini memaksa halaman untuk redirect kembali ke halaman 'index' (List User)
     * setelah proses create selesai.
     */
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
