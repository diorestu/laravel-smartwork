<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShiftPhoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cabang_configs', function (Blueprint $table) {
            $table->boolean('is_photo_enabled')->default(false)->after('radius_max');
            $table->boolean('is_using_shift')->default(false)->after('radius_max');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cabang_configs', function (Blueprint $table) {
            //
        });
    }
}
