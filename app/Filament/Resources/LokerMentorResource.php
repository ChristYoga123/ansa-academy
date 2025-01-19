<?php

namespace App\Filament\Resources;

use Exception;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\LokerMentor;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\Grid;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Actions\Action;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LokerMentorResource\Pages;
use Hugomyb\FilamentMediaAction\Tables\Actions\MediaAction;
use App\Filament\Resources\LokerMentorResource\RelationManagers;

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
                Forms\Components\Fieldset::make('dataDiri')
                    ->label('Data Diri')
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
                    ]),
                Forms\Components\Fieldset::make('prestasi')
                    ->label('Prestasi & Portofolio')
                    ->schema([
                        Forms\Components\Grid::make()
                            ->columns(1)
                            ->schema([
                                Forms\Components\TextInput::make('mahasiswa_berprestrasi')
                                    ->label('Tingkat Mahasiswa Berprestasi'),
                                Forms\Components\Textarea::make('alasan_mendaftar')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('pencapaian')
                                    ->columnSpanFull()
                                    ->required(),
                                Forms\Components\TextInput::make('drive_portofolio')
                                    ->required(),
                            ])
                    ]),
                
                Forms\Components\Fieldset::make('mediaSosial')
                    ->label('Media Sosial')
                    ->schema([
                        Forms\Components\TextInput::make('linkedin')
                            ->required()
                            ->prefixIcon('heroicon-o-link')
                            ->maxLength(191),
                        Forms\Components\TextInput::make('instagram')
                            ->prefixIcon('heroicon-o-link')
                            ->required()
                            ->maxLength(191),
                    ]),

                Forms\Components\Fieldset::make('status')
                    ->label('Status')
                    ->schema([
                        Forms\Components\Grid::make()
                            ->columns(1)
                            ->schema([
                                Forms\Components\TextInput::make('status_penerimaan')
                                    ->required(),
                                Forms\Components\Textarea::make('alasan_ditolak')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('universitas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('semester')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_penerimaan')
                    ->badge()
                    ->color(fn(LokerMentor $record) => match ($record->status_penerimaan) {
                        'Diterima' => 'success',
                        'Ditolak' => 'danger',
                        'Menunggu' => 'warning',
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
                    ->label('CV')
                    ->media(fn(LokerMentor $lokerMentor) => $lokerMentor->getFirstMediaUrl('calon-mentor-cv'))
                    ->autoplay(),
                Tables\Actions\Action::make('terima')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->label('Terima')
                    ->requiresConfirmation()
                    ->visible(fn(LokerMentor $lokerMentor) => $lokerMentor->status_penerimaan === 'Menunggu')
                    ->action(function(LokerMentor $lokerMentor){
                        DB::beginTransaction();
                        try
                        {
                            $lokerMentor->update(['status_penerimaan' => 'Diterima']);

                            // create user mentor
                            $user = User::firstOrCreate([
                                'name' => $lokerMentor->nama,
                                'email' => $lokerMentor->email,
                            ], [
                                'password' => bcrypt('password'),
                                'custom_fields' => [
                                    'no_hp' => $lokerMentor->no_hp,
                                    'universitas' => $lokerMentor->universitas,
                                    'semester' => $lokerMentor->semester,
                                    'alasan_mendaftar' => $lokerMentor->alasan_mendaftar,
                                    'mahasiswa_berprestrasi' => $lokerMentor->mahasiswa_berprestrasi,
                                    'pencapaian' => $lokerMentor->pencapaian,
                                    'drive_portofolio' => $lokerMentor->drive_portofolio,
                                    'linkedin' => $lokerMentor->linkedin,
                                    'instagram' => $lokerMentor->instagram,
                                ]
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
                    ->visible(fn(LokerMentor $lokerMentor) => $lokerMentor->status_penerimaan === 'Menunggu')
                    ->form([
                        Textarea::make('alasan_ditolak')
                            ->required(),
                    ])
                    ->action(function(LokerMentor $lokerMentor, array $data){
                        DB::beginTransaction();
                        try
                        {
                            $lokerMentor->update(['status_penerimaan' => 'Ditolak']);
                            $lokerMentor->update(['alasan_ditolak' => $data['alasan_ditolak']]);
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
                Tables\Actions\ViewAction::make()
                    ->infolist([
                        Fieldset::make('Data Diri')
                            ->schema([
                                TextEntry::make('nama'),
                                TextEntry::make('email')
                                    ->prefixAction(
                                        Action::make('email')
                                            ->icon('heroicon-o-envelope')
                                            ->url(fn(LokerMentor $record) => "mailto:{$record->email}")
                                            ->openUrlInNewTab()
                                    ),
                                TextEntry::make('no_hp')
                                    ->prefixAction(
                                        Action::make('phone')
                                            ->icon('heroicon-o-phone')
                                            ->url(fn(LokerMentor $record) => "https://wa.me/{$record->no_hp}")
                                            ->openUrlInNewTab()
                                    ),
                                TextEntry::make('universitas'),
                                TextEntry::make('semester'),
                            ]),
                        
                        Fieldset::make('Prestasi & Portofolio')
                            ->schema([
                                TextEntry::make('mahasiswa_berprestrasi'),
                                TextEntry::make('alasan_mendaftar'),
                                TextEntry::make('drive_portofolio')
                                    ->columnSpanFull()
                                    ->prefixAction(
                                    Action::make('drive')
                                    ->icon('heroicon-o-link')
                                    ->url(fn(LokerMentor $record) => $record->drive_portofolio)
                                    ->openUrlInNewTab()
                                ),
                                TextEntry::make('pencapaian')
                                    ->columnSpanFull()
                                    ->formatStateUsing(function(LokerMentor $record){
                                        $result = [];
                                        foreach($record->pencapaian as $key => $value) {
                                            $result[] = ($key + 1) . ' : ' . $value;
                                        }
                                        return nl2br(implode("\n", $result));
                                        // atau bisa langsung: return implode("<br>", $result);
                                    })
                                    ->html(),  // Penting! Tambahkan ini agar HTML tag dirender
                            ]),
                        
                        Fieldset::make('Media Sosial')
                            ->schema([
                                TextEntry::make('linkedin')
                                    ->prefixAction(
                                        Action::make('linkedin')
                                            ->icon('heroicon-o-link')
                                            ->url(fn(LokerMentor $record) => $record->linkedin)
                                            ->openUrlInNewTab()
                                    ),
                                TextEntry::make('instagram')
                                    ->prefixAction(
                                        Action::make('instagram')
                                            ->icon('heroicon-o-link')
                                            ->url(fn(LokerMentor $record) => $record->instagram)
                                            ->openUrlInNewTab()
                                    ),
                            ]),
                        
                        Fieldset::make('Status')
                            ->schema([
                                Grid::make()
                                    ->columns(1)
                                    ->schema([
                                        TextEntry::make('status_penerimaan')
                                            ->badge()
                                            ->color(fn(LokerMentor $record) => match ($record->status_penerimaan) {
                                                'Diterima' => 'success',
                                                'Ditolak' => 'danger',
                                                'Menunggu' => 'warning',
                                            }),
                                        TextEntry::make('alasan_ditolak')
                                            ->getStateUsing(fn(LokerMentor $record) => $record->alasan_ditolak ? $record->alasan_ditolak : 'Belum ada balasan')
                                            ->badge(fn(LokerMentor $record) => !$record->alasan_ditolak)
                                            ->color(fn(LokerMentor $record) => !$record->alasan_ditolak ? 'gray' : ''),
                                    ])
                            ]),
                    ]),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn(LokerMentor $lokerMentor) => $lokerMentor->status_penerimaan !== 'Menunggu'),
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
            'index' => Pages\ManageLokerMentors::route('/'),
        ];
    }
}