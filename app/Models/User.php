<?php

namespace App\Models;

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
    ];

    // banyak user punya banyak role
    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'user_roles', 'id_user', 'id_role');
    }

    // cek memiliki role tertentu (single role)
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    // cek memiliki salah satu dari banyak role (multiple role OR)
    public function hasAnyRole($roles)
    {
        if (!is_array($roles)) {
            $roles = [$roles];
        }

        return $this->roles()->whereIn('name', $roles)->exists();
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
