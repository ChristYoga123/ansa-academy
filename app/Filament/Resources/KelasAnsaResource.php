<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KelasAnsaResource\Pages;
use App\Filament\Resources\KelasAnsaResource\RelationManagers;
use App\Models\KelasAnsa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KelasAnsaResource extends Resource
{
    protected static ?string $model = KelasAnsa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Kelas Ansa';

    public static function form(Form $form): Form
    {
        $dataKelas = Forms\Components\Wizard\Step::make('dataKelas')
            ->label('Data Kelas')
            ->schema([
                Forms\Components\TextInput::make('judul')
                ->required()
                ->maxLength(191),
                Forms\Components\SpatieMediaLibraryFileUpload::make('thumbnail')
                    ->required()
                    ->maxFiles(1)
                    ->maxSize(1024)
                    ->image()
                    ->collection('kelas-ansa-thumbnail'),
                Forms\Components\Select::make('mentors')
                    ->relationship('mentors', 'name', fn(Builder $query) => $query->whereHas('roles', fn($query) => $query->where('name', 'mentor')))
                    ->required()
                    ->multiple()
                    ->preload()
                    ->searchable(),
                Forms\Components\TextInput::make('link_meet')
                    ->required()
                    ->url(),
                Forms\Components\RichEditor::make('deskripsi')
                    ->required()
                    ->columnSpanFull(),
                ]);

        $dataJadwal = Forms\Components\Wizard\Step::make('dataJadwal')
            ->label('Data Jadwal')
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\DateTimePicker::make('waktu_open_registrasi')
                            ->required(),
                        Forms\Components\DateTimePicker::make('waktu_close_registrasi')
                            ->required(),
                    ]),
                Forms\Components\DateTimePicker::make('waktu_pelaksanaan')
                    ->required(),
            ]);

        $dataPaket = Forms\Components\Wizard\Step::make('pricingKelas')
            ->label('Pricing Kelas')
            ->schema([
                Forms\Components\Repeater::make('pricing')
                    ->relationship('kelasAnsaPakets')
                    ->schema([
                        Forms\Components\TextInput::make('label')
                            ->required(),
                        Forms\Components\TextInput::make('harga')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->prefix('Rp')
                            ->suffix(',00'),
                    ])
            ]);
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(1)
                    ->schema([
                        Forms\Components\Wizard::make()
                            ->steps([
                                $dataKelas,
                                $dataJadwal,
                                $dataPaket,
                            ])
                            ->skippable(fn(string $operation) => $operation === 'edit'),
                ]),
        
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('thumbnail')
                    ->collection('kelas-ansa-thumbnail'),
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
            'index' => Pages\ManageKelasAnsas::route('/'),
        ];
    }
}
