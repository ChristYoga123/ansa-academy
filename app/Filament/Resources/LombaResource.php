<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LombaResource\Pages;
use App\Filament\Resources\LombaResource\RelationManagers;
use App\Models\Lomba;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
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
                Forms\Components\Grid::make()
                    ->columns(1)
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(191),
                        Forms\Components\SpatieMediaLibraryFileUpload::make('thumbnail')
                            ->required()
                            ->maxFiles(1)
                            ->maxSize(1024)
                            ->image()
                            ->collection('lomba-thumbnail'),
                        Forms\Components\TextInput::make('penyelenggara')
                            ->required()
                            ->maxLength(191),
                        Forms\Components\RichEditor::make('deskripsi')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Grid::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\DateTimePicker::make('waktu_open_registrasi')
                                    ->required()
                                    ->label('Waktu Open Registrasi'),
                                Forms\Components\DateTimePicker::make('waktu_close_registrasi')
                                    ->required()
                                    ->label('Waktu Close Registrasi'),
                            ]),
                        Forms\Components\TextInput::make('link_pendaftaran')
                            ->required()
                            ->url(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->collection('lomba-thumbnail'),
                Tables\Columns\TextColumn::make('penyelenggara')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->getStateUsing(fn(Lomba $lomba) => Carbon::now()->between($lomba->waktu_open_registrasi, $lomba->waktu_close_registrasi) ? 'Terbuka' : 'Tutup')
                    ->color(fn(Lomba $lomba) => Carbon::now()->between($lomba->waktu_open_registrasi, $lomba->waktu_close_registrasi) ? 'success' : 'danger'),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLombas::route('/'),
        ];
    }
}
