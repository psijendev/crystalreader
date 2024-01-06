<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

use Filament\Tables\Columns\TextColumn;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                Select::make('role')
                ->searchable()
                ->options([
                    'Admin' => 'ADMIN',
                    'User' => 'USER',
                ]),
                Select::make('countrycode')
                ->searchable()
                ->options([
                    960 => 'MV',
                    100 => 'US',
                ]),
                TextInput::make('phoneno')->numeric(),
                TextInput::make('email')->email(),
                TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn ($state) => Hash::make($state))

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name')->copyable()->copyMessage('Name copied!')->searchable(),
                TextColumn::make('email')->copyable()->copyMessage('Email address copied')->searchable(),
                TextColumn::make('countrycode'),
                TextColumn::make('phoneno'),
                TextColumn::make('role')->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Admin' => 'success',
                    'User' => 'warning',
                }),
                TextColumn::make('status')->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Active' => 'success',
                    'Pending' => 'warning',
                    'Blocked' => 'danger'
                }),
                TextColumn::make('email_verified_at'),
                TextColumn::make('password')->wrap(),
                TextColumn::make('created_at')->since(),
                TextColumn::make('updated_at')->since(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
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

    public function getTableBulkActions()
    {
        return  [
            ExportAction::make()->exports([
                ExcelExport::make()->withColumns([
                    Column::make('name'),
                    Column::make('role'),
                    Column::make('status'),
                    Column::make('countrycode'),
                    Column::make('phoneno'),
                    Column::make('email'),
                    Column::make('email_verified_at'),
                    Column::make('password'),
                    Column::make('created_at'),
                    Column::make('deleted_at'),
                ]),
            ]),
        ];
    }
}
