<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nomor_member',
        'nik',
        'nama_member',
        'no_hp',
        'email'
    ];

    public function transaksis()
    {
        return $this->hasMany(related: Transaksi::class);
    }
}
