<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Member' ,0)->description('Total member MancaPlay Saat ini'),
            Stat::make('Sisa Generate Token',0)->description('Sisa generate token bulan ini'),
            Stat::make('User' , auth()->user()->name)->description('Username akun anda')
        ];
    }
}
