<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjualanKredit extends Model
{
    protected $table = 'penjualan_kredit';
    protected $primaryKey = 'id_penjualan_kredit';
    protected $fillable = [
        'pelanggan_id',
        'user_id',
        'tanggal_penjualan',
        'total_harga',
        'sisa_angsur',
        'down_payment',
        'bunga',
        'jangka_pembayaran',
        'total_angsur_bulanan',
        'status',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function detailPenjualanKredit()
    {
        return $this->hasMany(DetailPenjualanKredit::class, 'penjualan_kredit_id');
    }

    public function angsuran()
    {
        return $this->hasMany(Angsuran::class, 'penjualan_kredit_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($penjualanKredit) {
            $penjualanKredit->detailPenjualanKredit()->delete();

            $penjualanKredit->angsuran()->delete();
        });
    }
}
