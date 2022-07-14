<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCabangConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cabang_configs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_admin')->unsigned();
            $table->integer('id_cabang')->unsigned()->nullable();
            $table->boolean('is_radius')->nullable();
            $table->integer('radius_max')->unsigned()->nullable();
            $table->string('bank_type')->nullable();
            $table->date('tgl_tutup')->nullable();
            $table->text('komponen_gaji')->nullable();
            $table->string('pph21')->nullable();
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
        Schema::dropIfExists('cabang_configs');
    }
}
