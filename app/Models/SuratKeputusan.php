<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeputusan extends Model
{
    use HasFactory;

    protected $table = 'surat_keputusan';

    protected $fillable = [
        'nomor_sk',
        'judul_sk',
        'isi_sk',
        'tanggal_sk',
        'status_dekan',
        'status_warek1',
        'nama_dekan',
        'nama_warek1',
        'nip_warek1'
    ];
}
