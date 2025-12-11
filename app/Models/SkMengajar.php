<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkMengajar extends Model
{
    use HasFactory;

    protected $table = 'sk_mengajar';

    protected $fillable = [
        'nomor_sk',
        'tahun_akademik',
        'semester',
        'tanggal_terbit',
        'dosen_nama',
        'mata_kuliah',
        'kelas',
        'sks',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
    ];
}
