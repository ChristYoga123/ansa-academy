<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Event;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EventResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EventResource\RelationManagers;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Event';

    public static function form(Form $form): Form
    {
        $dataEvent = Forms\Components\Wizard\Step::make('dataEvent')
            ->label('Data Event')
            ->schema([
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(191),
                Forms\Components\SpatieMediaLibraryFileUpload::make('thumbnail')
                    ->required()
                    ->image()
                    ->maxFiles(1)
                    ->maxSize(1024)
                    ->collection('event-thumbnail'), 
                Forms\Components\Select::make('mentors')
                    ->relationship('mentors', 'name', fn(Builder $query) => $query->whereHas('roles', fn($query) => $query->where('name', 'mentor')))
                    ->required()
                    ->multiple()
                    ->searchable()
                    ->preload(),
                Forms\Components\RichEditor::make('deskripsi')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('kuota')
                    ->required()
                    ->numeric(),
            ]);

        $scheduleEvent = Forms\Components\Wizard\Step::make('scheduleEvent')
            ->label('Waktu & Tempat Event')
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
                    Forms\Components\Select::make('jenis')
                    ->options([
                        'online' => 'Online',
                        'offline' => 'Offline',
                    ])
                    ->live()
                    ->required(),
                Forms\Components\TextInput::make('link_meet')
                    ->url()
                    ->live()
                    ->required(fn(Get $get) => $get('jenis') === 'online')
                    ->visible(fn(Get $get) => $get('jenis') === 'online'),
                Forms\Components\TextInput::make('venue')
                    ->required(fn(Get $get) => $get('jenis') === 'offline')
                    ->visible(fn(Get $get) => $get('jenis') === 'offline')
                    ->maxLength(191),
            ]);
        
        $pricingEvent = Forms\Components\Wizard\Step::make('pricingEvent')
            ->label('Pricing Event')
            ->schema([
                Forms\Components\Select::make('pricing')
                    ->options([
                        'gratis' => 'Gratis',
                        'berbayar' => 'Berbayar',
                    ])
                    ->afterStateUpdated(function ($state, Set $set) {
                        if ($state === 'gratis') {
                            $set('harga', 0);
                        }
                    })
                    ->live()
                    ->required(),
                Forms\Components\TextInput::make('harga')
                    ->numeric()
                    ->required(fn(Get $get) => $get('pricing') === 'berbayar')
                    ->visible(fn(Get $get) => $get('pricing') === 'berbayar')
                    ->prefix('Rp')
                    ->suffix(',00'),
            ]);
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(1)
                    ->schema([
                        Forms\Components\Wizard::make()
                            ->steps([
                                $dataEvent,
                                $scheduleEvent,
                                $pricingEvent,
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
                    ->collection('event-thumbnail'),
                Tables\Columns\TextColumn::make('jenis')
                    ->sortable()
                    ->getStateUsing(fn(Event $event) => $event->jenis === 'online' ? 'Online' : 'Offline')
                    ->badge(),
                Tables\Columns\TextColumn::make('pricing')
                    ->searchable()
                    ->badge()
                    ->getStateUsing(fn(Event $event) => $event->pricing === 'gratis' ? 'Gratis' : 'Berbayar'),
                Tables\Columns\TextColumn::make('harga')
                    ->weight(FontWeight::Bold)
                    ->money('IDR')
                    ->getStateUsing(fn(Event $event) => $event->harga ? $event->harga : 0)
                    ->sortable(),
                Tables\Columns\TextColumn::make('kuota')
                    ->weight(FontWeight::Bold)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    // get state using carbon cek waktu_pelaksanaan > now
                    ->getStateUsing(fn(Event $event) => Carbon::parse($event->waktu_pelaksanaan)->isPast() ? 'Selesai' : 'Upcoming')
                    ->color(fn(Event $event) => Carbon::parse($event->waktu_pelaksanaan)->isPast() ? 'danger' : 'success'),
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
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function(array $data)
                    {
                        if($data['pricing'] === 'gratis')
                        {
                            $data['harga'] = 0;
                        }

                        return $data;
                    }),
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
            'index' => Pages\ManageEvents::route('/'),
        ];
    }
}
