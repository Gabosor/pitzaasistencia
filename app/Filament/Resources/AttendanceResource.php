<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Actions\Action;

use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;



class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Asistencia';
    protected static ?string $modelLabel = 'Registro de Asistencia';
    protected static ?string $navigationGroup = 'Gestión';
    protected static ?int $navigationSort = 7;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\DateTimePicker::make('timestamp')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('timestamp')
                    ->dateTime()
                    ->label('Ingreso')
                    ->sortable(),
                 Tables\Columns\TextColumn::make('user.apellidos')
                    ->label('Apellidos')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.nombres')
                    ->label('Nombres')
                    ->searchable()
                    ->sortable(),
                
            ])
            ->filters([
                //
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
               // Tables\Actions\EditAction::make(),
            ])
            
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([

                ]),
            ])
            ->headerActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function canCreate(): bool
    {
        return false;
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
