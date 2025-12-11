<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'kode',
        'nama',
        'jumlah_kelas',
        'nama_kelas',
        'kapasitas',
        'semester',
        'keterangan'
    ];

    protected $casts = [
        'jumlah_kelas' => 'integer',
        'kapasitas' => 'integer',
        'nama_kelas'
    ];
}
