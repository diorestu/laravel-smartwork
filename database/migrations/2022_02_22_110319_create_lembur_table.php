<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLemburTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lembur', function (Blueprint $table) {
            $table->id();
            $table->integer("id_user");
            $table->dateTime('lembur_awal')->nullable();
            $table->dateTime('lembur_akhir')->nullable();
            $table->string('lembur_keterangan');
            $table->integer('jam_kerja');
            $table->integer('jam_lembur');
            $table->integer('approve_by');
            $table->dateTime('approve_date')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lembur');
    }
}
