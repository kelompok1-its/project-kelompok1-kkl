<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkMengajarsTable extends Migration
{
    public function up()
    {
        Schema::create('sk_mengajar', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_sk')->unique();
            $table->string('tahun_akademik');
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->date('tanggal_terbit');
            $table->string('dosen_nama');
            $table->string('mata_kuliah');
            $table->string('kelas');
            $table->integer('sks');
            $table->enum('status', ['Draft', 'Disetujui', 'Ditandatangani', 'Dibatalkan'])->default('Draft');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sk_mengajar');
    }
}
