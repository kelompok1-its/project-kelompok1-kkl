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

        'final_status',
        'final_by',
        'final_at',
        'final_remarks',
    ];

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function matakuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'matakuliah_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function approverFinal()
    {
        return $this->belongsTo(User::class, 'final_by');
    }

    public function suratKeputusan()
    {
        return $this->hasOne(SuratKeputusan::class);
    }
}
