<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProofreadingResource\Pages;
use App\Filament\Resources\ProofreadingResource\RelationManagers;
use App\Models\Proofreading;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProofreadingResource extends Resource
{
    protected static ?string $model = Proofreading::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Proofreading';

    public static function form(Form $form): Form
    {
        $dataProofreading = Forms\Components\Wizard\Step::make('Data Proofreading')
            ->schema([
                Forms\Components\TextInput::make('judul')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(191),
                Forms\Components\SpatieMediaLibraryFileUpload::make('thumbnail')
                    ->required()
                    ->image()
                    ->maxSize(1024)
                    ->maxFiles(1)
                    ->collection('proofreading-thumbnail'),
                Forms\Components\RichEditor::make('deskripsi')
                    ->required()
                    ->columnSpanFull(),
            ]);

        $dataPricing = Forms\Components\Wizard\Step::make('Data Pricing')
            ->schema([
                Forms\Components\Repeater::make('proofreadingPakets')
                    ->relationship('proofreadingPakets')
                    ->schema([
                        Forms\Components\Select::make('jenis')
                            ->required()
                            ->options([
                                'Reguler' => 'Reguler',
                                'Premium' => 'Premium',
                            ]),
                        Forms\Components\TextInput::make('harga')
                            ->required()
                            ->numeric()
                            ->minValue(1),
                    ])
            ]);
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(1)
                    ->schema([
                        Forms\Components\Wizard::make()
                            ->steps([
                                $dataProofreading,
                                $dataPricing,
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
                Tables\Columns\SpatieMediaLibraryImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->collection('proofreading-thumbnail'),
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
            'index' => Pages\ManageProofreadings::route('/'),
        ];
    }
}
