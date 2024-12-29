<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MentoringResource\Pages;
use App\Filament\Admin\Resources\MentoringResource\RelationManagers;
use App\Models\Mentoring;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MentoringResource extends Resource
{
    protected static ?string $model = Mentoring::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Mentoring';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->columns(1)
                    ->schema([
                        Fieldset::make('data_mentoring')
                            ->columns(1)
                            ->label('Data Mentoring')
                            ->schema([
                                Forms\Components\Select::make('kategori_mentoring_id')
                                    ->label('Kategori Mentoring')
                                    ->required()
                                    ->relationship('kategori', 'nama')
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('nama')
                                            ->required()
                                            ->maxLength(191),
                                    ]),
                                Forms\Components\TextInput::make('judul')
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->maxLength(191),
                                SpatieMediaLibraryFileUpload::make('mentoring-thumbnail')
                                    ->collection('mentoring-thumbnail')
                                    ->image()
                                    ->required()
                                    ->maxFiles(1)
                                    ->maxSize(1024),
                                Forms\Components\Select::make('mentors')
                                    ->label('Mentor')
                                    ->relationship('mentors', 'name', fn(Builder $query) => $query->whereHas('roles', fn($query) => $query->where('name', 'mentor')))
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\Repeater::make('bidangs')
                                    ->label('Bidang Mentoring')
                                    ->relationship()
                                    ->required()
                                    ->schema([
                                        Forms\Components\TextInput::make('nama')
                                            ->required()
                                            ->maxLength(191),
                                    ]),
                                Forms\Components\RichEditor::make('deskripsi')
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                        
                        Fieldset::make('data_pricing')
                            ->label('Data Pricing')
                            ->columns(1)
                            ->schema([
                                Forms\Components\Repeater::make('pakets')
                                    ->relationship()
                                    ->label('Paket Mentoring')
                                    ->required()
                                    ->schema([
                                        Forms\Components\Select::make('jenis')
                                            ->options([
                                                'Lanjutan' => 'Lanjutan',
                                                'Pemula' => 'Pemula',
                                            ])
                                            ->required(),
                                        Forms\Components\TextInput::make('label')
                                            ->required()
                                            ->maxLength(191),
                                        Forms\Components\TextInput::make('jumlah_pertemuan')
                                            ->required()
                                            ->numeric(),
                                        Forms\Components\TextInput::make('harga')
                                            ->required()
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->suffix('.00'),
                                    ]),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kategori.nama')
                    ->label('Kategori Mentoring')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                SpatieMediaLibraryImageColumn::make('mentoring-thumbnail')
                    ->collection('mentoring-thumbnail'),
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
            'index' => Pages\ListMentorings::route('/'),
            'create' => Pages\CreateMentoring::route('/create'),
            'view' => Pages\ViewMentoring::route('/{record}'),
            'edit' => Pages\EditMentoring::route('/{record}/edit'),
        ];
    }
}
