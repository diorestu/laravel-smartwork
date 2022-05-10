<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKpiMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kpi_master', function (Blueprint $table) {
            $table->id();
            $table->string('kpi_master', 100)->nullable();
            $table->integer('id_admin');
            $table->date('kpi_periode_awal_m')->nullable();
            $table->date('kpi_periode_akhir_m')->nullable();
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
        Schema::dropIfExists('kpi_master');
    }
}
