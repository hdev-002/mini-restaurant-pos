<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    const ROLE_ADMIN = 'ADMIN';
    const ROLE_STAFF = 'STAFF';
    const ROLE_CASHIER = 'CASHIER';

    const ROLES = [
      self::ROLE_ADMIN => 'Admin',
      self::ROLE_STAFF => 'Staff',
      self::ROLE_CASHIER => 'Cashier'
    ];

    public function canAccessPanel(Panel $panel): bool
    {
       return true;
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isStaff()
    {
        return $this->role === self::ROLE_STAFF  || $this->role === self::ROLE_ADMIN;
    }

    public function isCashier()
    {
        return $this->role === self::ROLE_CASHIER || $this->role === self::ROLE_ADMIN;
    }


    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
        ];
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }
}
