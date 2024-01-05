<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookmarkResource\Pages;
use App\Filament\Resources\BookmarkResource\RelationManagers;
use App\Models\Bookmark;
use App\Models\User;
use App\Models\Document;

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

class BookmarkResource extends Resource
{
    protected static ?string $model = Bookmark::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                ->label('Belongs to User')
                ->options(User::all()->pluck('name', 'id'))
                ->searchable(),

                Select::make('document_id')
                ->label('On Document')
                ->options(Document::all()->pluck('title', 'id'))
                ->searchable(),

                Select::make('status')
                ->searchable()
                ->options([
                    'Active' => 'Active',
                    'Deleted' => 'Deleted',
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->wrap(),
                TextColumn::make('document.title')->wrap(),
                TextColumn::make('status')->wrap(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookmarks::route('/'),
            'create' => Pages\CreateBookmark::route('/create'),
            'edit' => Pages\EditBookmark::route('/{record}/edit'),
        ];
    }
}
