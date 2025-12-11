<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('matakuliah', function (Blueprint $table) {
            $table->id();

            // Kode dan nama MK
            $table->string('kode_mk')->unique();
            $table->string('nama_mk');

            // Detail SKS & kelas
            $table->integer('sks');
            $table->string('kelas')->nullable();

            // Kurikulum
            $table->string('kurikulum')->nullable();

            // Informasi fakultas & prodi
            $table->string('fakultas')->nullable();
            $table->string('prodi')->nullable();
            $table->string('kode_prodi')->nullable();

            // Status
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('matakuliah');
    }
};
