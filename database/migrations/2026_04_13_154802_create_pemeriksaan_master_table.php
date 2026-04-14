<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePemeriksaanMasterTable extends Migration
{
    public function up()
    {
        Schema::create('pemeriksaan_master', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('petugas_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('dokter_id')->nullable()->constrained('users')->onDelete('set null');
            $table->datetime('tanggal_pemeriksaan')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->float('tinggi_cm')->nullable();
            $table->float('berat_kg')->nullable();
            $table->float('lingkar_perut_cm')->nullable();
            $table->integer('sistolik')->nullable();
            $table->integer('diastolik')->nullable();
            $table->enum('status_validasi', ['draft', 'divalidasi', 'dibatalkan'])->default('draft');
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Index
            $table->index('tanggal_pemeriksaan');
            $table->index('status_validasi');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pemeriksaan_master');
    }
}
