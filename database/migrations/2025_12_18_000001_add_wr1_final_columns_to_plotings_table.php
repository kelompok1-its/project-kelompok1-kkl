<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWr1FinalColumnsToPlotingsTable extends Migration
{
    public function up()
    {
        Schema::table('plotings', function (Blueprint $table) {
            $table->string('final_status')->nullable()->after('status'); // pending / approved / rejected oleh WR1
            $table->unsignedBigInteger('final_by')->nullable()->after('final_status');
            $table->timestamp('final_at')->nullable()->after('final_by');
            $table->text('final_remarks')->nullable()->after('final_at');

            // optional FK:
            // $table->foreign('final_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('plotings', function (Blueprint $table) {
            $table->dropColumn(['final_status', 'final_by', 'final_at', 'final_remarks']);
        });
    }
}