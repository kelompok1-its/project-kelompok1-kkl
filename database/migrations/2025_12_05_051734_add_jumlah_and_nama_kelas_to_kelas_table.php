<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->integer('jumlah_kelas')->default(1)->after('nama');
            $table->string('nama_kelas')->nullable()->after('jumlah_kelas');
        });
    }

    public function down()
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn(['jumlah_kelas', 'nama_kelas']);
        });
    }
};
