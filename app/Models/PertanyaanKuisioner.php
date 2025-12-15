<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PertanyaanKuisioner extends Model
{
    protected $table = 'pertanyaan_kuisioner';

    protected $fillable = [
        'judul',
        'pertanyaan',
        'created_by'
    ];

    public function jawaban()
    {
        return $this->hasMany(JawabanKuisioner::class, 'pertanyaan_id');
    }
}
