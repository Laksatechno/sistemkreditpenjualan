<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisBarang extends Model
{
    use HasFactory;

    protected $table = 'jenis_barang';
    protected $primaryKey = 'id_jenis';
    protected $fillable = [
        'nama_jenis',
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'jenis_id', 'id_jenis');
    }
}
