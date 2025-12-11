<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;

    protected $table = 'matakuliah';

    // Mass assignable fields
    protected $fillable = [
        'kode_mk',
        'nama_mk',
        'sks',
        'kelas',
        'kurikulum',
        'fakultas',
        'prodi',
        'kode_prodi',
        'status'
    ];
}
