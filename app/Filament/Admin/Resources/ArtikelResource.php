<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Artikel;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\ArtikelResource\Pages;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Admin\Resources\ArtikelResource\RelationManagers;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class ArtikelResource extends Resource
{
    protected static ?string $model = Artikel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::user()->id),
                Forms\Components\TextInput::make('judul')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),
                SpatieMediaLibraryFileUpload::make('artikel-thumbnail')
                    ->collection('artikel-thumbnail')
                    ->rules(['required'])
                    ->image()
                    ->required(),
                Forms\Components\RichEditor::make('konten')
                    ->required()
                    ->rules(['required']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Artikel::query()->whereUserId(Auth::user()->id))
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                SpatieMediaLibraryImageColumn::make('artikel-thumbnail')
                    ->label('Thumbnail')
                    ->collection('artikel-thumbnail'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListArtikels::route('/'),
            'create' => Pages\CreateArtikel::route('/create'),
            'view' => Pages\ViewArtikel::route('/{record}'),
            'edit' => Pages\EditArtikel::route('/{record}/edit'),
        ];
    }
}
