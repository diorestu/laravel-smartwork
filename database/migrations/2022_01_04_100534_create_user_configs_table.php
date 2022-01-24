<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_configs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_admin')->unsigned();
            $table->string('layout_mode', 100)->nullable();
            $table->string('nomor_surat', 100)->nullable();
            $table->double('max_user', 12, 0)->nullable();
            $table->enum('tipe_akun', ['basic','advance','pro']);
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
        Schema::dropIfExists('user_configs');
    }
}
