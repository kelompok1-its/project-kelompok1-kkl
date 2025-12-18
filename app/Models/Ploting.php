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
        'prodi_id',
        'semester',
        'tahun_akademik',
        'created_by',
        'status',
        'approved_by',
        'approved_at',
        'remarks',
        // WR1 final approval fields
        'final_status',
        'final_by',
        'final_at',
        'final_remarks',
    ];

    public function dosen()
    {
        return $this->belongsTo(\App\Models\User::class, 'dosen_id');
    }

    public function matakuliah()
    {
        return $this->belongsTo(\App\Models\MataKuliah::class, 'matakuliah_id');
    }

    public function kelas()
    {
        return $this->belongsTo(\App\Models\Kelas::class, 'kelas_id');
    }

    public function prodi()
    {
        return $this->belongsTo(\App\Models\Prodi::class, 'prodi_id');
    }

    public function approver()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }

    // relasi untuk final approver (WR1)
    public function approverFinal()
    {
        return $this->belongsTo(\App\Models\User::class, 'final_by');
    }
}