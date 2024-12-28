<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Mentor;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\MentorResource\Pages;
use Hugomyb\FilamentMediaAction\Tables\Actions\MediaAction;
use App\Filament\Admin\Resources\MentorResource\RelationManagers;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class MentorResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Mentor';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $model): bool
    {
        return false;
    }

    public static function canEdit(Model $model): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->columns(1)
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('poster')
                            ->label('Poster')
                            ->collection('mentor-poster')
                            ->required()
                            ->maxFiles(1)
                            ->image()
                            ->rules(['required', 'image', 'mimes:jpeg,png,jpg', 'max:1024'])
                            ->maxSize('1024'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(User::query()->whereHas('roles', fn (Builder $query) => $query->where('name', 'mentor')))
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Mentor')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                ImageColumn::make('avatar_url')
                    ->label('Avatar'),
                SpatieMediaLibraryImageColumn::make('mentor-poster')
                    ->label('Poster')
                    ->collection('mentor-poster'),
            ])
            ->filters([
                //
            ])
            ->actions([
                MediaAction::make('lihatCV')
                    ->icon('heroicon-o-document')
                    ->color('info')
                    ->label('Lihat CV')
                    ->media('https://www.youtube.com/watch?v=at_tl8J2nYY'),
                Tables\Actions\Action::make('lihatPortofolio')
                    ->icon('heroicon-o-link')
                    ->color('warning')
                    ->label('Lihat Portofolio')
                    ->url(fn(User $user) => $user->custom_fields['drive_portofolio'])
                    ->openUrlInNewTab(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->label('Edit Poster'),
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
            'index' => Pages\ListMentors::route('/'),
            'create' => Pages\CreateMentor::route('/create'),
            'view' => Pages\ViewMentor::route('/{record}'),
            'edit' => Pages\EditMentor::route('/{record}/edit'),
        ];
    }
}
