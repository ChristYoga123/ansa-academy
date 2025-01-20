<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Mentoring;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Wizard;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use App\Filament\Resources\MentoringResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\MentoringResource\RelationManagers;

class MentoringResource extends Resource
{
    protected static ?string $model = Mentoring::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Mentoring';

    public static function form(Form $form): Form
    {
        $mentoringDetail = Step::make('Detail Mentoring')
            ->schema([
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
                Forms\Components\Repeater::make('mentoringBidangs')
                    ->label('Bidang Mentoring')
                    ->relationship('mentoringBidangs')
                    ->required()
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(191),
                    ]),
                Forms\Components\RichEditor::make('deskripsi')
                    ->required()
                    ->columnSpanFull(),
            ]);

        $mentoringPricing = Step::make('Pricing Mentoring')
            ->schema([
                Forms\Components\Repeater::make('mentoringPakets')
                    ->relationship('mentoringPakets')
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
            ]);
        return $form
            ->schema([
                Grid::make()
                    ->columns(1)
                    ->schema([
                        Wizard::make(['Data Mentoring', 'Pricing Mentoring'])
                            ->steps([
                                $mentoringDetail,
                                $mentoringPricing,
                            ])
                            ->skippable(fn(string $operation) => $operation === 'edit'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
            'index' => Pages\ManageMentorings::route('/'),
        ];
    }
}
