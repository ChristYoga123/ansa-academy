<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\EbookResource\Pages;
use App\Filament\Admin\Resources\EbookResource\RelationManagers;
use App\Models\Ebook;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Hugomyb\FilamentMediaAction\Tables\Actions\MediaAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EbookResource extends Resource
{
    protected static ?string $model = Ebook::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->columns(1)
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                    SpatieMediaLibraryFileUpload::make('ebook-thumbnail')
                        ->collection('ebook-thumbnail')
                        ->rules(['image', 'max:1024', 'mimes:png,jpg,jpeg'])
                        ->image()
                        ->required()
                        ->maxFiles(1)
                        ->maxSize(1024),
                    SpatieMediaLibraryFileUpload::make('ebook-file')
                        ->collection('ebook-file')
                        ->rules(['file', 'max:10240', 'mimes:pdf'])
                        ->required()
                        ->maxFiles(1)
                        ->maxSize(10240),
                    Forms\Components\TextInput::make('harga')
                        ->required()
                        ->prefix('Rp')
                        ->suffix('.00')
                        ->numeric(),
                    Forms\Components\RichEditor::make('deskripsi')
                        ->required()
                        ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('harga')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
                SpatieMediaLibraryImageColumn::make('ebook-thumbnail')
                    ->label('Thumbnail')
                    ->collection('ebook-thumbnail'),
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
                MediaAction::make('ebook-file')
                    ->label('File')
                    ->icon('heroicon-o-document')
                    ->color('info')
                    ->media(fn(Ebook $ebook) => $ebook->getFirstMediaUrl('ebook-file')),
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
            'index' => Pages\ListEbooks::route('/'),
            'create' => Pages\CreateEbook::route('/create'),
            'view' => Pages\ViewEbook::route('/{record}'),
            'edit' => Pages\EditEbook::route('/{record}/edit'),
        ];
    }
}
