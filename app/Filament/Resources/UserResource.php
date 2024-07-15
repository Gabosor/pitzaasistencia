<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Empleados';
    protected static ?string $modelLabel = 'Empleado';
    protected static ?string $navigationGroup = 'Gestión';
    protected static ?int $navigationSort = 9;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Correo')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ci')
                    ->required(),
                Forms\Components\TextInput::make('nombres')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('apellidos')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('fechaIng')
                    ->default(now())
                    ->required(),
                Forms\Components\Select::make('rol')
                    ->required()
                    ->options([
                        '0' => 'Empleado',
                        '1' => 'Admin',
                    ])
                    ->default('empleado'),
                Forms\Components\TextInput::make('SalarioBase')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('telefono')
                    ->tel()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('ci')
                    ->label('Carnet')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nombres')
                    ->searchable(),
                Tables\Columns\TextColumn::make('apellidos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fechaIng')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rol')
                    ->label('Rol')
                    ->formatStateUsing(fn ($state) => $state ? 'Admin' : 'Empleado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('SalarioBase')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('telefono')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('changePassword')
                    ->label('Cambiar Contraseña')
                    ->form([
                        Forms\Components\TextInput::make('current_password')
                            ->label('Contraseña Actual')
                            ->password()
                            ->required()
                            ->rules(['current_password']),
                        Forms\Components\TextInput::make('new_password')
                            ->label('Nueva Contraseña')
                            ->password()
                            ->required()
                            ->minLength(8),
                        Forms\Components\TextInput::make('confirm_password')
                            ->label('Confirmar Contraseña')
                            ->password()
                            ->required()
                            ->same('new_password'),
                    ])
                    ->action(function (array $data) {
                        $user = Auth::user();

                        // Verificar la contraseña actual
                        if (!Hash::check($data['current_password'], $user->password)) {
                            throw new \Exception('La contraseña actual no es correcta.');
                        }

                        // Actualizar la contraseña
                        $user->password = Hash::make($data['new_password']);
                        $user->save();
                    })
                    ->modalHeading('Cambiar Contraseña')
                    ->modalButton('Guardar')
                    ->requiresConfirmation()
                    ->visible(fn (User $record) => $record->id === Auth::id()), 
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
