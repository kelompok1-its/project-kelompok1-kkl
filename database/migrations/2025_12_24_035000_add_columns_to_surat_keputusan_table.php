<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSuratKeputusanTable extends Migration
{
    public function up()
    {
        // Pastikan tabel ada
        if (! Schema::hasTable('surat_keputusan')) {
            Schema::create('surat_keputusan', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('ploting_id')->nullable()->index();
                $table->string('nomor_sk')->nullable();
                $table->string('status_dekan')->nullable();
                $table->string('status_warek1')->nullable();
                $table->date('tanggal_sk')->nullable();
                $table->string('file_path')->nullable();
                $table->unsignedBigInteger('created_by')->nullable();
                $table->timestamps();

                // optional foreign key, aktifkan jika ingin enforce:
                // $table->foreign('ploting_id')->references('id')->on('plotings')->onDelete('cascade');
            });
            return;
        }

        // Jika tabel sudah ada, tambahkan kolom yang hilang jika belum ada
        Schema::table('surat_keputusan', function (Blueprint $table) {
            if (! Schema::hasColumn('surat_keputusan', 'ploting_id')) {
                $table->unsignedBigInteger('ploting_id')->nullable()->index()->after('id');
            }
            if (! Schema::hasColumn('surat_keputusan', 'nomor_sk')) {
                $table->string('nomor_sk')->nullable()->after('ploting_id');
            }
            if (! Schema::hasColumn('surat_keputusan', 'status_dekan')) {
                $table->string('status_dekan')->nullable()->after('nomor_sk');
            }
            if (! Schema::hasColumn('surat_keputusan', 'status_warek1')) {
                $table->string('status_warek1')->nullable()->after('status_dekan');
            }
            if (! Schema::hasColumn('surat_keputusan', 'tanggal_sk')) {
                $table->date('tanggal_sk')->nullable()->after('status_warek1');
            }
            if (! Schema::hasColumn('surat_keputusan', 'file_path')) {
                $table->string('file_path')->nullable()->after('tanggal_sk');
            }
            if (! Schema::hasColumn('surat_keputusan', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('file_path');
            }
            if (! Schema::hasColumn('surat_keputusan', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    public function down()
    {
        // Hati-hati di down: hapus hanya kolom yang kita tambahkan
        if (Schema::hasTable('surat_keputusan')) {
            Schema::table('surat_keputusan', function (Blueprint $table) {
                if (Schema::hasColumn('surat_keputusan', 'created_by')) {
                    $table->dropColumn('created_by');
                }
                if (Schema::hasColumn('surat_keputusan', 'file_path')) {
                    $table->dropColumn('file_path');
                }
                if (Schema::hasColumn('surat_keputusan', 'tanggal_sk')) {
                    $table->dropColumn('tanggal_sk');
                }
                if (Schema::hasColumn('surat_keputusan', 'status_warek1')) {
                    $table->dropColumn('status_warek1');
                }
                if (Schema::hasColumn('surat_keputusan', 'status_dekan')) {
                    $table->dropColumn('status_dekan');
                }
                if (Schema::hasColumn('surat_keputusan', 'nomor_sk')) {
                    $table->dropColumn('nomor_sk');
                }
                if (Schema::hasColumn('surat_keputusan', 'ploting_id')) {
                    $table->dropColumn('ploting_id');
                }
            });
        }
    }
}