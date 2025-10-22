<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    protected $table = 'user_roles'; // pastikan sesuai nama tabel

    protected $fillable = [
        'id_user',
        'id_role',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi ke Role
    public function role()
    {
        return $this->belongsTo(Roles::class, 'id_role');
    }
}
