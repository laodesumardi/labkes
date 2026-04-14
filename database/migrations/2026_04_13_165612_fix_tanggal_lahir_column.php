<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixTanggalLahirColumn extends Migration
{
    public function up()
    {
        // Ubah tipe data tanggal_lahir menjadi date
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->change();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'tanggal_lahir')) {
                $table->string('tanggal_lahir')->nullable()->change();
            }
        });
    }
}
