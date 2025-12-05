<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->string('kode');
            $table->string('nama');
            $table->integer('jumlah_kelas')->default(0);
            $table->string('nama_kelas')->nullable(); // untuk A, B, C
            $table->integer('kapasitas')->default(0);
            $table->string('semester')->nullable();
            $table->text('keterangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('kelas');
    }
}
