<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Layanan extends Model
{
    use SoftDeletes;

    protected $fillable = ['nama_layanan', 'harga', 'satuan', 'deskripsi'];

    // Relasi ke Transaksi
    public function transaksis()
    {
        return $this->hasManyThrough(
            Transaksi::class,       // Model akhir
            TransaksiDetail::class, // Model perantara
            'layanan_id',           // FK di transaksi_details
            'id',                   // PK di transaksis
            'id',                   // PK di layanan
            'transaksi_id'          // FK di transaksi_details ke transaksis
        );
    }

    public function detailTransaksis()
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }
}
