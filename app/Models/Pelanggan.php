<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    protected $fillable = [
        'nama_pelanggan',
        'alamat',
        'telepon',
        'file_identitas',
    ];

    public function penjualanKredit()
    {
        return $this->hasMany(PenjualanKredit::class, 'pelanggan_id');
    }
}
