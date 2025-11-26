<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatakuliahTable extends Migration
{
    public function up()
    {
        Schema::create('matakuliah', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mk');
            $table->string('nama_mk');
            $table->integer('sks');
            $table->integer('semester');
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('matakuliah');
    }
}
