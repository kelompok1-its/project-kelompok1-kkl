<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlotingsTable extends Migration
{
    public function up()
    {
        Schema::create('plotings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('matakuliah_id');
            $table->unsignedBigInteger('kelas_id')->nullable();
            $table->string('semester')->nullable();
            $table->string('tahun_akademik')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            // jika ingin aktifkan FK, uncomment dan pastikan tabel target ada
            // $table->foreign('dosen_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('matakuliah_id')->references('id')->on('mata_kuliahs')->onDelete('cascade');
            // $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('plotings');
    }
}
