<?php
namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Pedido;
use App\Models\Factura;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PedidoResource\Pages;
use Filament\Notifications\Notification;

class PedidoResource extends Resource
{
    protected static ?string $model = Pedido::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->label('Empleado')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('estado')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->searchable()
                    ->label('Fecha Pedido')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('client.nombres')
                    ->searchable()
                    ->label('Cliente Nombre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('client.apellidos')
                    ->label('Cliente Apellidos')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('date_range')
                    ->form([
                        DatePicker::make('start_date')
                            ->label('Inicio Fecha')
                            ->default(now()),
                        DatePicker::make('end_date')
                            ->default(now())
                            ->label('Fin Fecha'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['start_date'], fn (Builder $query, $date) => $query->whereDate('created_at', '>=', $date))
                            ->when($data['end_date'], fn (Builder $query, $date) => $query->whereDate('created_at', '<=', $date));
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['start_date'] ?? null) {
                            $indicators['start_date'] = 'Start Date: ' . (new \DateTime($data['start_date']))->format('F j, Y');
                        }

                        if ($data['end_date'] ?? null) {
                            $indicators['end_date'] = 'End Date: ' . (new \DateTime($data['end_date']))->format('F j, Y');
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                Action::make('toggleEstado')
                    ->label('Cambiar Estado')
                    ->action(function (Pedido $record) {
                        $record->estado = !$record->estado;
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-arrow-path'),
                Action::make('printFactura')
                    ->label('Imprimir Factura')
                    ->action(function (Pedido $record) {
                        $facturaExistente = Factura::where('pedido_id', $record->id)->first();
                        if ($facturaExistente) {
                            Notification::make()
                                ->title('Error')
                                ->body('La factura para este pedido ya ha sido impresa.')
                                ->danger()
                                ->send();
                            return;
                        }
                        return redirect()->route('print.factura', $record);
                    })
                    ->color('primary')
                    ->icon('heroicon-o-printer'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ])
            ->defaultSort('created_at', 'desc');  // Añade esta línea para ordenar por fecha de creación en orden descendente
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPedidos::route('/'),
            'create' => Pages\CreatePedido::route('/create'),
            'edit' => Pages\EditPedido::route('/{record}/edit'),
        ];
    }
}
