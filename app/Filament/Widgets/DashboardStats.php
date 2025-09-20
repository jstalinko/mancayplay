<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        if(auth()->user()->license_fc25 && auth()->user()->license_fc26)
        {
            $stat = Stat::make('Sisa Generate Token',auth()->user()->generate_token_quota.' + ' . auth()->user()->generate_token_quota_fc26)->description('Sisa generate token bulan ini untuk FC2025 dan FC 2026');
        }elseif(auth()->user()->license_fc26 && !auth()->user()->license_fc25)
        {
            $stat = Stat::make('Sisa Generate Token FC52026',auth()->user()->generate_token_quota_fc26)->description('Sisa generate token bulan ini untuk FC2026');
        }elseif(auth()->user()->license_fc25 && !auth()->user()->license_fc26)
        {
             $stat = Stat::make('Sisa Generate Token FC2025',auth()->user()->generate_token_quota)->description('Sisa generate token bulan ini untuk FC2025');
        }else{
            $stat = Stat::make('Sisa Generate Token',0)->description('Beli FC2025 / FC2026 Untuk mendapatkan fitur generate token');
        }
        return [
            Stat::make('Total Member' ,User::count())->description('Total member MancayPlay Saat ini'),
            $stat,
            Stat::make('User' , auth()->user()->name)->description('Username akun anda')
        ];
    }
}
