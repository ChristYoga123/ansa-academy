<?php

namespace App\Filament\Admin\Resources;

use Exception;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\LokerMentor;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Grid;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use App\LokerMentor\StatusPenerimaanEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\LokerMentorResource\Pages;
use Hugomyb\FilamentMediaAction\Tables\Actions\MediaAction;
use App\Filament\Admin\Resources\LokerMentorResource\RelationManagers;
use App\Models\User;

class LokerMentorResource extends Resource
{
    protected static ?string $model = LokerMentor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Loker Mentor';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()    
                    ->columns(1)
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(191),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(191),
                        Forms\Components\TextInput::make('no_hp')
                            ->required()
                            ->maxLength(191),
                        Forms\Components\TextInput::make('universitas')
                            ->required()
                            ->maxLength(191),
                        Forms\Components\TextInput::make('semester')
                            ->required(),
                        Forms\Components\Textarea::make('alasan_mendaftar')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('mahasiswa_berprestrasi')
                            ->required(),
                        Forms\Components\Textarea::make('pencapaian')
                            ->required(),
                            // ->getState(fn($value) => json_encode($value)),
                        Forms\Components\Textarea::make('drive_portofolio')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('status_penerimaan')
                            ->required(),
                        Forms\Components\Textarea::make('alasan_ditolak')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('universitas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('semester'),
                Tables\Columns\TextColumn::make('mahasiswa_berprestrasi'),
                Tables\Columns\TextColumn::make('status_penerimaan')
                    ->badge()
                    ->color(fn(LokerMentor $record) => match ($record->status_penerimaan) {
                        StatusPenerimaanEnum::DITERIMA => 'success',
                        StatusPenerimaanEnum::DITOLAK => 'danger',
                        StatusPenerimaanEnum::MENUNGGU => 'warning',
                    }),
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
                MediaAction::make('lihatCV')
                    ->icon('heroicon-o-document')
                    ->color('info')
                    ->label('Lihat CV')
                    ->media('https://www.youtube.com/watch?v=at_tl8J2nYY'),
                Tables\Actions\Action::make('lihatPortofolio')
                    ->icon('heroicon-o-link')
                    ->color('warning')
                    ->label('Lihat Portofolio')
                    ->url(fn(LokerMentor $lokerMentor) => $lokerMentor->drive_portofolio)
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('terima')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->label('Terima')
                    ->requiresConfirmation()
                    ->visible(fn(LokerMentor $lokerMentor) => $lokerMentor->status_penerimaan === StatusPenerimaanEnum::MENUNGGU)
                    ->action(function(LokerMentor $lokerMentor){
                        DB::beginTransaction();
                        try
                        {
                            $lokerMentor->update(['status_penerimaan' => StatusPenerimaanEnum::DITERIMA]);

                            // create user mentor
                            $user = User::firstOrCreate([
                                'name' => $lokerMentor->nama,
                                'email' => $lokerMentor->email,
                            ], [
                                'password' => bcrypt('password'),
                                'custom_fields' => json_encode([
                                    'no_hp' => $lokerMentor->no_hp,
                                    'universitas' => $lokerMentor->universitas,
                                    'semester' => $lokerMentor->semester,
                                    'alasan_mendaftar' => $lokerMentor->alasan_mendaftar,
                                    'mahasiswa_berprestrasi' => $lokerMentor->mahasiswa_berprestrasi,
                                    'pencapaian' => $lokerMentor->pencapaian,
                                    'drive_portofolio' => $lokerMentor->drive_portofolio,
                                ])
                            ]);

                            $user->assignRole('mentor');

                            // check if user has media cv
                            if($lokerMentor->hasMedia('calon-mentor-cv'))
                            {
                                $lokerMentor->getFirstMedia('calon-mentor-cv')->copy($user, 'mentor-cv');
                            }

                            DB::commit();
                            Notification::make()
                                ->title('Berhasil')
                                ->body('Data loker mentor diterima')
                                ->success()
                                ->send();
                        }catch(Exception $e)
                        {
                            DB::rollBack();
                            Notification::make()
                                ->title('Gagal')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
                Tables\Actions\Action::make('tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->label('Tolak')
                    ->requiresConfirmation()
                    ->visible(fn(LokerMentor $lokerMentor) => $lokerMentor->status_penerimaan === StatusPenerimaanEnum::MENUNGGU)
                    ->action(function(LokerMentor $lokerMentor){
                        DB::beginTransaction();
                        try
                        {
                            $lokerMentor->update(['status_penerimaan' => StatusPenerimaanEnum::DITOLAK]);

                            DB::commit();
                            Notification::make()
                                ->title('Berhasil')
                                ->body('Data loker mentor ditolak')
                                ->success()
                                ->send();
                        }catch(Exception $e)
                        {
                            DB::rollBack();
                            Notification::make()
                                ->title('Gagal')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->hidden(fn(LokerMentor $lokerMentor) => $lokerMentor->status_penerimaan === StatusPenerimaanEnum::MENUNGGU),
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
            'index' => Pages\ListLokerMentors::route('/'),
            'create' => Pages\CreateLokerMentor::route('/create'),
            'view' => Pages\ViewLokerMentor::route('/{record}'),
            'edit' => Pages\EditLokerMentor::route('/{record}/edit'),
        ];
    }
}
