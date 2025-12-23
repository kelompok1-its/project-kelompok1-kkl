<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class JawabanKuisioner extends Model
{
    // Jika tabel Anda bernama lain, sesuaikan nama tabel di bawah
    protected $table = 'jawaban_kuisioner';

    protected $fillable = [
        'pertanyaan_id',
        'jawaban',
        'created_by', // kolom penjawab; ganti jika di DB pakai 'dosen_id' atau 'user_id'
    ];

    public function pertanyaan()
    {
        return $this->belongsTo(PertanyaanKuisioner::class, 'pertanyaan_id');
    }

    // Relasi ke user/dosen yang mengisi jawaban
    public function dosen()
    {
        // Asumsi kolom penjawab bernama created_by; ganti ke 'dosen_id' bila perlu
        return $this->belongsTo(User::class, 'created_by');
    }
}
