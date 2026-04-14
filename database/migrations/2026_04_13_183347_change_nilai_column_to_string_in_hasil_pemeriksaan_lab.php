<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNilaiColumnToStringInHasilPemeriksaanLab extends Migration
{
    public function up()
    {
        Schema::table('hasil_pemeriksaan_lab', function (Blueprint $table) {
            $table->string('nilai', 255)->change();
        });
    }

    public function down()
    {
        Schema::table('hasil_pemeriksaan_lab', function (Blueprint $table) {
            $table->float('nilai')->change();
        });
    }
}
