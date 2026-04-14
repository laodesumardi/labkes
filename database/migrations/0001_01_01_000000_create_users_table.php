<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 50)->unique();
            $table->string('nama_lengkap', 100);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'dokter', 'petugas_lab', 'pasien'])->default('pasien');
            $table->string('no_telepon', 15)->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->timestamp('last_login')->nullable();
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
