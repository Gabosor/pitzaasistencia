<?php
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Pedido;
use App\Models\Service;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Card;

class IncomeExpensesWidget extends ChartWidget
{
    protected static ?string $heading = 'Ingresos y Egresos';

    public ?string $startDate = null;
    public ?string $endDate = null;

    protected function getFormSchema(): array
    {
        return [
            DatePicker::make('startDate')
                ->label('Fecha de Inicio')
                ->required(),
            DatePicker::make('endDate')
                ->label('Fecha de Fin')
                ->required(),
        ];
    }

    protected function getData(): array
    {
        $startDate = $this->startDate ?? now()->startOfMonth();
        $endDate = $this->endDate ?? now()->endOfMonth();

        $totalIngresos = Pedido::whereBetween('created_at', [$startDate, $endDate])
            ->sum('total');

        $totalEgresos = Service::whereBetween('created_at', [$startDate, $endDate])
            ->sum('pagoSer');

        $balance = $totalIngresos - $totalEgresos;

        return [
            'datasets' => [
                [
                    'label' => 'Ingresos Totales',
                    'data' => [$totalIngresos],
                    'backgroundColor' => '#4caf50',
                ],
                [
                    'label' => 'Egresos Totales',
                    'data' => [$totalEgresos],
                    'backgroundColor' => '#f44336',
                ],
                [
                    'label' => 'Balance',
                    'data' => [$balance],
                    'backgroundColor' => '#2196f3',
                ],
            ],
            'labels' => ['Total'],
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Hoy',
            'week' => 'Esta Semana',
            'month' => 'Este Mes',
            'year' => 'Este Año',
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
