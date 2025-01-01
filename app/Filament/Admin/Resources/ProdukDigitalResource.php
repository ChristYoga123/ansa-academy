<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ProdukDigital;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Hugomyb\FilamentMediaAction\Tables\Actions\MediaAction;
use App\Filament\Admin\Resources\ProdukDigitalResource\Pages;
use App\Filament\Admin\Resources\ProdukDigitalResource\RelationManagers;

class ProdukDigitalResource extends Resource
{
    protected static ?string $model = ProdukDigital::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Produk Digital';

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
                        SpatieMediaLibraryFileUpload::make('produk-digital-thumbnail')
                            ->required()
                            ->image()
                            ->maxFiles(1)
                            ->maxSize(1024)
                            ->collection('produk-digital-thumbnail'),
                        Forms\Components\RichEditor::make('deskripsi')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Select::make('platform')
                            ->label('Media')
                            ->selectablePlaceholder(false)
                            ->options([
                                'url' => 'URL',
                                'file' => 'File',
                            ])
                            ->live()
                            ->default('url')
                            ->required(),
                        SpatieMediaLibraryFileUpload::make('produk-digital-file')
                            ->required(fn(Get $get) => $get('platform') === 'file')
                            ->live()
                            ->label('File (PDF, ZIP, RAR, DLL) (Max 1 file, Max 10MB)')
                            ->maxFiles(1)
                            ->maxSize(10240)
                            ->collection('produk-digital-file')
                            ->hidden(fn(Get $get) => $get('platform') === 'url'),
                        Forms\Components\TextInput::make('url')
                            ->maxLength(191)
                            ->live()
                            ->rules(['url'])
                            ->required(fn(Get $get) => $get('platform') === 'url')
                            ->hidden(fn(Get $get) => $get('platform') === 'file'),
                        Forms\Components\TextInput::make('harga')
                            ->required()
                            ->prefix('Rp')
                            ->suffix(',00')
                            ->numeric(),
                        Forms\Components\Toggle::make('is_unlimited')
                            ->required()
                            ->live()
                            ->default(true),
                        Forms\Components\TextInput::make('qty')
                            ->numeric()
                            ->live()
                            ->visible(fn(Get $get) => !$get('is_unlimited'))
                            ->required(fn(Get $get) => !$get('is_unlimited')),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('platform'),
                Tables\Columns\TextColumn::make('harga')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('qty')
                    ->label('Stok')
                    ->getStateUsing(fn(ProdukDigital $produkDigital) => $produkDigital->is_unlimited ? 'Unlimited' : $produkDigital->qty)
                    ->sortable(),
                Tables\Columns\TextColumn::make('ketersediaan')
                    ->getStateUsing(fn(ProdukDigital $produkDigital) => $produkDigital->qty !== 0 ? 'Tersedia' : 'Tidak Tersedia')
                    ->badge()
                    ->color(fn(ProdukDigital $produkDigital) => $produkDigital->qty !== 0 ? 'success' : 'danger'),
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
                Filter::make('created_at')
                    ->form([
                        Forms\Components\Select::make('ketersediaan')
                            ->options([
                                'tersedia' => 'Tersedia',
                                'tidak-tersedia' => 'Tidak Tersedia',
                            ])
                            ->label('Ketersediaan'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['ketersediaan'] === 'tersedia',
                                fn(Builder $query) => $query->where('qty', '>', 0)->orWhere('is_unlimited', true)
                            )
                            ->when(
                                $data['ketersediaan'] === 'tidak-tersedia',
                                fn(Builder $query) => $query->where('qty', 0)
                            );
                    }),
                ], layout: FiltersLayout::AboveContent)
            ->actions([
                MediaAction::make('produkDigitalFile')
                    ->media(fn(ProdukDigital $produkDigital) => $produkDigital->platform === 'url' ? $produkDigital->url : $produkDigital->getFirstMediaUrl('produk-digital-file'))
                    ->color('info')
                    ->label('Lihat File')
                    ->icon('heroicon-o-document'),
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
            'index' => Pages\ListProdukDigitals::route('/'),
            'create' => Pages\CreateProdukDigital::route('/create'),
            'view' => Pages\ViewProdukDigital::route('/{record}'),
            'edit' => Pages\EditProdukDigital::route('/{record}/edit'),
        ];
    }
}
