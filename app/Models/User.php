<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasAvatar, HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_url',
        'custom_fields',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'custom_fields' => 'json',
        ];
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_mentors', 'mentor_id', 'event_id')->withPivot('id');
    }

    public function mentorings()
    {
        return $this->belongsToMany(Mentoring::class, 'mentoring_mentors', 'mentor_id', 'mentoring_id')->withPivot('id');
    }

    public function kelasAnsas()
    {
        return $this->belongsToMany(KelasAnsa::class, 'kelas_ansa_mentors', 'mentor_id', 'kelas_ansa_id')->withPivot('id');
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url("$this->avatar_url") : null;
    }

    public function registerMediaCollection(): void
    {
        $this->addMediaCollection('mentor-poster')
            ->singleFile();
        $this->addMediaCollection('mentor-cv')
            ->singleFile();
    }
}
