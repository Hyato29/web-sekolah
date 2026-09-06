<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    public function hasRole($roleName): bool
    {
        return $this->role()->where('name', $roleName)->exists();
    }

    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    /**
     * Relasi ke profil Siswa (1 Akun User memiliki 1 Profil Siswa)
     */
    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }
}
