<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMethodPajakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('method_pajak', function (Blueprint $table) {
            $table->id();
            $table->integer('id_admin');
            $table->integer('id_cabang');
            $table->string('metode_pajak');
            $table->integer('periode_bulan');
            $table->integer('periode_tahun');
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
        Schema::dropIfExists('method_pajak');
    }
}
