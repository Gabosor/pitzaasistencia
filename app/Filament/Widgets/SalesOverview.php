<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Pedido;
use Carbon\Carbon;

class SalesOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $todaySales = Pedido::whereDate('created_at', Carbon::today())->sum('total');
        $todayOrders = Pedido::whereDate('created_at', Carbon::today())->count();

        return [
            Stat::make('Ventas de Hoy', number_format($todaySales, 2) . ' BS')
                ->description('Total de ventas realizadas hoy')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'),

            Stat::make('Pedidos de Hoy', $todayOrders)
                ->description('Número de pedidos realizados hoy')
                ->descriptionIcon('heroicon-o-shopping-cart')
                ->color('primary'),
        ];
    }
}
