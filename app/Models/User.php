<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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
            'role' => UserRole::class,
        ];
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function fines()
    {
        return $this->hasMany(Fine::class);
    }

    public function hasRole(string $role): bool
    {
        return $this->role->value === $role;
    }
}