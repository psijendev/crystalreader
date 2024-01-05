<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatalogResource\Pages;
use App\Filament\Resources\CatalogResource\RelationManagers;
use App\Models\Catalog;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class CatalogResource extends Resource
{
    protected static ?string $model = Catalog::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title'),
                TextInput::make('description'),

                SpatieMediaLibraryFileUpload::make('cover')
                    ->collection('covers')
                    ->disk('local')
                    ->preserveFilenames()
                    ->previewable(true)
                    ->downloadable(),
                Section::make('Metadata')
                ->schema([
                    KeyValue::make('Catalog Meta-data')
                        ->keyLabel('Field name')
                        ->valueLabel('Field value')
                        ->reorderable(),
                ]),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->wrap(),
                TextColumn::make('description')->wrap(),
                TextColumn::make('user.name')->label("Added By User")->wrap(),
                TextColumn::make('metadata')->wrap(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            RelationManagers\DocumentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCatalogs::route('/'),
            'create' => Pages\CreateCatalog::route('/create'),
            'edit' => Pages\EditCatalog::route('/{record}/edit'),
        ];
    }
}
