<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Member' ,User::count())->description('Total member MancayPlay Saat ini'),
            Stat::make('Sisa Generate Token',auth()->user()->generate_token_quota.'x')->description('Sisa generate token bulan ini'),
            Stat::make('User' , auth()->user()->name)->description('Username akun anda')
        ];
    }
}
