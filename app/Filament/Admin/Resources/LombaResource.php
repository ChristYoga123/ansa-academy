<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LombaResource\Pages;
use App\Filament\Admin\Resources\LombaResource\RelationManagers;
use App\Models\Lomba;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LombaResource extends Resource
{
    protected static ?string $model = Lomba::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Lomba';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->columns(1)
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(191),
                        SpatieMediaLibraryFileUpload::make('lomba-thumbnail')
                            ->collection('lomba-thumbnail')
                            ->rules(['image', 'max:1024', 'mimes:png,jpg,jpeg'])
                            ->image()
                            ->required()
                            ->maxFiles(1)
                            ->maxSize(1024),
                        Forms\Components\TextInput::make('penyelenggara')
                            ->required()
                            ->maxLength(191),
                        Forms\Components\RichEditor::make('deskripsi')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\DateTimePicker::make('waktu_open_registrasi')
                            ->label('Open Registrasi')
                            ->required(),
                        Forms\Components\DateTimePicker::make('waktu_close_registrasi')
                            ->label('Close Registrasi')
                            ->required(),
                        Forms\Components\TextInput::make('link_pendaftaran')
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
                Tables\Columns\TextColumn::make('penyelenggara')
                    ->searchable(),
                Tables\Columns\TextColumn::make('waktu_open_registrasi')
                    ->label('Open Registrasi')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('waktu_close_registrasi')
                    ->label('Close Registrasi')
                    ->dateTime()
                    ->sortable(),
                SpatieMediaLibraryImageColumn::make('lomba-thumbnail')
                    ->label('Thumbnail')
                    ->collection('lomba-thumbnail'),
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
            'index' => Pages\ListLombas::route('/'),
            'create' => Pages\CreateLomba::route('/create'),
            'view' => Pages\ViewLomba::route('/{record}'),
            'edit' => Pages\EditLomba::route('/{record}/edit'),
        ];
    }
}
