<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualanKredit extends Model
{
    protected $table = 'detail_penjualan_kredit';
    protected $primaryKey = 'id_detail_penjualan_kredit';
    protected $fillable = [
        'penjualan_kredit_id',
        'barang_id',
        'kuantitas',
        'harga_satuan',
        'sub_total',
    ];

    public function penjualanKredit()
    {
        return $this->belongsTo(PenjualanKredit::class, 'penjualan_kredit_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
