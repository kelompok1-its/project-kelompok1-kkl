<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeputusan extends Model
{
    protected $table = 'surat_keputusan';

    protected $fillable = [
        'ploting_id',
        'nomor_sk',
        'status_dekan',
        'status_warek1',
        'tanggal_sk',
        'file_path',
        'created_by',
    ];

    public function ploting()
    {
        return $this->belongsTo(Ploting::class, 'ploting_id');
    }
}
