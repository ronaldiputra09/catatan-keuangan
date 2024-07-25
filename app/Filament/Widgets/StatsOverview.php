<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $pemasukan = Transaction::whereHas('category', function ($query) {
            $query->where('is_expense', false);
        })
            ->sum('amount');
        $pengeluaran = Transaction::whereHas('category', function ($query) {
            $query->where('is_expense', true);
        })
            ->sum('amount');
        return [
            Stat::make('Total Pemasukan', $pemasukan),
            Stat::make('Total Pengeluaran', $pengeluaran),
            Stat::make('Selisih', $pemasukan - $pengeluaran),
        ];
    }
}
