<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogShiftUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_shift_users', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user')->unsigned();
            $table->date('tgl_shift');
            $table->integer('id_shift_lama');
            $table->integer('id_shift_baru');
            $table->enum('status', ['menunggu', 'ditolak', 'disetujui'])->default('menunggu');
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
        Schema::dropIfExists('log_shift_users');
    }
}
