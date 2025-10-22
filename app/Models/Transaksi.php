<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nomor_transaksi',
        'member_id',
        'layanan_id',
        'berat',
        'tanggal_masuk',
        'estimasi_selesai',
        'status',
        'total_harga',
        'dibayar',
        'catatan'
    ];

    // Transaksi.php
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id');
    }

    // Transaksi.php
    public function layanan()
    {
        return $this->belongsToMany(Layanan::class, 'transaksi_details')
            ->withPivot('qty', 'harga', 'subtotal')
            ->withTimestamps();
    }
}
