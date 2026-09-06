<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // Tambahkan ini
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke tabel roles[cite: 1]
    public function role() {
        return $this->belongsTo(Role::class);
    }

    // Helper untuk mengecek role[cite: 1]
    public function hasRole($roleName): bool {
        return $this->role()->where('name', $roleName)->exists();
    }
}