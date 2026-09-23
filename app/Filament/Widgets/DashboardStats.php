<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();
        $licenses = [];
        $quotas = [];

        if ($user->license_fc25) {
            $licenses[] = 'FC2025';
            $quotas[] = $user->generate_token_quota;
        }
        if ($user->license_fc26) {
            $licenses[] = 'FC2026';
            $quotas[] = $user->generate_token_quota_fc26;
        }
        if ($user->license_fc27) {
            $licenses[] = 'FC2027';
            $quotas[] = $user->generate_token_quota_fc27;
        }

        if (!empty($licenses)) {
            $label = count($licenses) === 1 ? 'Sisa Generate Token ' . $licenses[0] : 'Sisa Generate Token';
            $value = implode(' + ', $quotas);
            $desc = 'Sisa generate token bulan ini untuk ' . implode(' dan ', $licenses);
            $stat = Stat::make($label, $value)->description($desc);
        } else {
            $stat = Stat::make('Sisa Generate Token', 0)->description('Beli FC2025 / FC2026 / FC2027 Untuk mendapatkan fitur generate token');
        }
        return [
            Stat::make('Total Member' ,User::count())->description('Total member MancayPlay Saat ini'),
            $stat,
            Stat::make('User' , auth()->user()->name)->description('Username akun anda')
        ];
    }
}
