<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilPemeriksaanLabTable extends Migration
{
    public function up()
    {
        Schema::create('hasil_pemeriksaan_lab', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemeriksaan_id')->constrained('pemeriksaan_master')->onDelete('cascade');
            $table->foreignId('parameter_id')->constrained('parameter_lab')->onDelete('cascade');
            $table->float('nilai');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['pemeriksaan_id', 'parameter_id'], 'unique_pemeriksaan_parameter');
        });
    }

    public function down()
    {
        Schema::dropIfExists('hasil_pemeriksaan_lab');
    }
}
