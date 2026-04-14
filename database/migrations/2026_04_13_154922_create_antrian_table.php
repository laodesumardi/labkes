<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntrianTable extends Migration
{
    public function up()
    {
        Schema::create('antrian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nomor_antrian', 20)->unique();
            $table->enum('jenis_pemeriksaan', ['darah', 'urin', 'lengkap']);
            $table->enum('status', ['menunggu', 'proses', 'selesai', 'batal'])->default('menunggu');
            $table->datetime('waktu_masuk')->useCurrent();
            $table->datetime('waktu_proses')->nullable();
            $table->datetime('waktu_selesai')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('antrian');
    }
}
