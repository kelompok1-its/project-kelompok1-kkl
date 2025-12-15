<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanKuisionerTable extends Migration
{
    public function up()
    {
        Schema::create('jawaban_kuisioner', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pertanyaan_id');
            $table->unsignedBigInteger('dosen_id');
            $table->text('jawaban');                       // Jawaban dosen
            $table->timestamps();

            $table->foreign('pertanyaan_id')
                ->references('id')->on('pertanyaan_kuisioner')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jawaban_kuisioner');
    }
}
