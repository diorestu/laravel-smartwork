<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('tgl_lahir')->nullable()->after('gender');
            $table->string('tempat_lahir')->nullable()->after('gender');
            $table->string('nik', 20)->nullable()->after('nip');
            $table->text('alamat_ktp')->nullable()->after('alamat');
            $table->string('kode_pos')->nullable()->after('alamat_ktp');
            $table->enum('tipe_id', ['KTP', 'SIM'])->nullable()->after('nik');
            $table->enum('gol_darah', ['A', 'AB', 'B', 'O'])->nullable()->after('gender');
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Buddha', 'Hindu', 'Konghucu', 'Atheis', 'Lainnya'])->nullable()->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
