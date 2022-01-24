<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user')->unsigned();
            $table->dateTime('jam_hadir');
            $table->dateTime('jam_pulang');
            $table->text('ket_hadir');
            $table->text('ket_pulang');
            $table->string('lat_hadir', 100);
            $table->string('long_hadir', 100);
            $table->string('lat_pulang', 100);
            $table->string('long_pulang', 100);
            $table->double('jam_kerja', 2, 0);
            $table->double('jam_lembur', 2, 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensis');
    }
}
