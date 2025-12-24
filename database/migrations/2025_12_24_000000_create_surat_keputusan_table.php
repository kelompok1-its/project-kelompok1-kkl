<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratKeputusanTable extends Migration
{
    public function up()
    {
        Schema::create('surat_keputusan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ploting_id')->index();  // relasi ke plotings.id
            $table->string('nomor_sk')->nullable();
            $table->date('tanggal_sk')->nullable();
            $table->string('file_path')->nullable(); // path file PDF SK jika disimpan
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            // foreign key optional — aktifkan jika tabel plotings pasti ada dan ingin enforce FK
            // $table->foreign('ploting_id')->references('id')->on('plotings')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('surat_keputusan');
    }
}