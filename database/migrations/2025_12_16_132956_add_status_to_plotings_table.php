<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToPlotingsTable extends Migration
{
    public function up()
    {
        Schema::table('plotings', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('created_by'); // pending / approved / rejected
            $table->unsignedBigInteger('approved_by')->nullable()->after('status');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->text('remarks')->nullable()->after('approved_at');

            // jika mau pakai foreign key (opsional), uncomment ketika tabel users ada
            // $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('plotings', function (Blueprint $table) {
            $table->dropColumn(['status', 'approved_by', 'approved_at', 'remarks']);
        });
    }
}
