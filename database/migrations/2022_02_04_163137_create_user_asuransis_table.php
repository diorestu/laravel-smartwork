<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAsuransisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_asuransis', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->string('status_nakes');
            $table->string('nomor_nakes');
            $table->double('pot_nakes');
            $table->string('status_naker');
            $table->string('nomor_naker');
            $table->double('pot_naker');
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
        Schema::dropIfExists('user_asuransis');
    }
}
