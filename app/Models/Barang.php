<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $fillable = [
        'nama_barang',
        'jenis_id',
        'merk',
        'stok',
        'satuan',
        'harga',
    ];

    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class, 'jenis_id', 'id_jenis');
    }
}
