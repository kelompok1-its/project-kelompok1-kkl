<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ploting extends Model
{
    protected $table = 'plotings';

    protected $fillable = [
        'dosen_id',
        'matakuliah_id',
        'kelas_id',
        'semester',
        'tahun_akademik',
        'created_by',
    ];

    public function dosen()
    {
        return $this->belongsTo(\App\Models\User::class, 'dosen_id');
    }

    public function matakuliah()
    {
        // sesuaikan nama model MataKuliah kalau berbeda
        return $this->belongsTo(\App\Models\MataKuliah::class, 'matakuliah_id');
    }

    public function kelas()
    {
        // sesuaikan nama model Kelas kalau berbeda
        return $this->belongsTo(\App\Models\Kelas::class, 'kelas_id');
    }
}
