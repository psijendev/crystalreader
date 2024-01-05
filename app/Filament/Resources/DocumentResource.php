<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Filament\Resources\DocumentResource\RelationManagers;
use App\Models\Document;
use App\Models\Catalog;

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




class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title'),
                TextInput::make('description'),

                SpatieMediaLibraryFileUpload::make('attachment')
                    ->collection('documents')
                    ->disk('local')
                    ->preserveFilenames()
                    ->acceptedFileTypes(['application/pdf'])
                    ->previewable(true)
                    ->downloadable()
                    ,

                Select::make('isCatalog')
                ->options([
                    'yes' => 'Yes',
                    'no' => 'No',
                ])->nullable()
                ->afterStateHydrated(function ($state, $component) {
                    $component->state(match ($state) {
                        true => 'yes',
                        false => 'no',
                        default => null,
                    });
                })
                ->dehydrateStateUsing(function ($state) {
                    return match ($state) {
                        'yes' => true,
                        'no' => false,
                        default => null,
                    };
                }),
                Select::make('catalog_id')
                ->label('Catalog')
                ->options(Catalog::all()->pluck('title', 'id'))
                ->searchable(),

                Select::make('status')
                ->label('Status')
                ->options([
                    "Active" => "Active",
                    "Pending" => "Pending",
                    "Blocked" => "Blocked"
                ])
                ->searchable(),

                Section::make('Document Meta-data')
                ->schema([
                    KeyValue::make('metadata')
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
                TextColumn::make('status')->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Active' => 'success',
                    'Pending' => 'warning',
                    'Blocked' => 'danger',
                }),
                TextColumn::make('isCatalog')->label("Belongs To Catalog?"),
                TextColumn::make('catalog.title')->label("Catalog"),
                TextColumn::make('metadata')->wrap(),
                TextColumn::make('user.name')->label("Added By User")->wrap(),
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
