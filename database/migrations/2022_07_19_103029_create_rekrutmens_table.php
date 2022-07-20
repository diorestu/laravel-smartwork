<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekrutmensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekrutmens', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('id_lowongan');
            $table->string('nik');
            $table->string('nama');
            $table->enum('gender', ['pria', 'wanita'])->nullable();
            $table->date('lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->text('url_cv')->nullable();
            $table->enum('status', ['waiting', 'appointment', 'interview', 'approved', 'reject'])->default('waiting');
            $table->enum('kawin', ['kawin', 'belum kawin'])->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('rekrutmens');
    }
}
