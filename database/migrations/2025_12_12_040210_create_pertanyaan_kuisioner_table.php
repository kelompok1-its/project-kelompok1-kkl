<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePertanyaanKuisionerTable extends Migration
{
    public function up()
    {
        Schema::create('pertanyaan_kuisioner', function (Blueprint $table) {
            $table->id();
            $table->string('judul');                   // Judul kuisioner
            $table->text('pertanyaan');               // Isi pertanyaan
            $table->unsignedBigInteger('created_by'); // Kaprodi
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pertanyaan_kuisioner');
    }
}
