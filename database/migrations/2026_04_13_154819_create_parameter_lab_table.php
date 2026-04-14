<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParameterLabTable extends Migration
{
    public function up()
    {
        Schema::create('parameter_lab', function (Blueprint $table) {
            $table->id();
            $table->string('kode_param', 50)->unique();
            $table->string('nama_param', 100);
            $table->string('satuan', 20)->nullable();
            $table->float('nilai_normal_min')->nullable();
            $table->float('nilai_normal_max')->nullable();
            $table->enum('kategori', ['kimia_darah', 'urin', 'serologi', 'narkoba', 'lainnya']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('parameter_lab');
    }
}
