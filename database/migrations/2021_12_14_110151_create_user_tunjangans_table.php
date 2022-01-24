<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTunjangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tunjangans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_user');
            $table->double('tj_jabatan');
            $table->double('tj_makan');
            $table->double('tj_transport');
            $table->double('tj_sertifikasi');
            $table->double('tj_lain');
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
        Schema::dropIfExists('user_tunjangans');
    }
}
