<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    protected $table = 'angsuran';
    protected $primaryKey = 'id_angsuran';
    protected $fillable = [
        'penjualan_kredit_id',
        'tanggal_pembayaran',
        'jumlah_angsur',
        'no_angsuran'
    ];

    public function penjualanKredit()
    {
        return $this->belongsTo(PenjualanKredit::class, 'penjualan_kredit_id');
    }
}
