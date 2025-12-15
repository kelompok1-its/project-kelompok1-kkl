<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanKuisioner extends Model
{
    protected $table = 'jawaban_kuisioner';

    protected $fillable = [
        'pertanyaan_id',
        'dosen_id',
        'jawaban',
    ];

    public function pertanyaan()
    {
        return $this->belongsTo(PertanyaanKuisioner::class, 'pertanyaan_id');
    }
}
