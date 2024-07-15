<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
class GeneratePdfPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
     protected static ?string $title = 'Generar Planilla de Sueldos';
     protected static ?string $navigationLabel = 'Generar Planilla de Sueldos';
    protected static string $view = 'filament.pages.generate-pdf-page';
    protected static ?string $navigationGroup = 'Gestión';
    protected static ?int $navigationSort = 6;
    public $month;
    public $year;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('month')
                ->label('Mes')
                ->options([
                    '1' => 'Enero',
                    '2' => 'Febrero',
                    '3' => 'Marzo',
                    '4' => 'Abril',
                    '5' => 'Mayo',
                    '6' => 'Junio',
                    '7' => 'Julio',
                    '8' => 'Agosto',
                    '9' => 'Septiembre',
                    '10' => 'Octubre',
                    '11' => 'Noviembre',
                    '12' => 'Diciembre',
                ])
                ->required(),
            
            Forms\Components\TextInput::make('year')
                    ->label('Año')
                ->numeric()
                ->required()
                ->minValue(2000)
                ->maxValue(date('Y')),
        ];
    }

    public function generatePdf()
    {
        $month = $this->month;
        $year = $this->year;

        if($month && $year) return redirect()->route('generate-pdf', ['month' => $month, 'year' => $year]);
        
        Notification::make()
            ->title('No hay información!')
            ->body('Porfavor selecciona un mes y ingresa un año.')
            ->warning()
            ->send();
    }
}
