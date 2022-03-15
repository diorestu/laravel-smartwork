<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->bigIncrements('id_pay');
            $table->integer('id_user');
            $table->double('pay_pokok');
            $table->double('bpjs_tk_u')->nullable();
            $table->double('bpjs_tk_p')->nullable();
            $table->double('bpjs_kes_u')->nullable();
            $table->double('bpjs_kes_p')->nullable();
            $table->double('tj_jabatan');
            $table->double('tj_sertifikasi');
            $table->double('tj_transport');
            $table->double('tj_kosmetik');
            $table->double('tj_makan');
            $table->double('tj_masaKerja');
            $table->double('tj_statusKawin');
            $table->double('tj_bonus');
            $table->double('pt_absen');
            $table->double('pt_kasbon');
            $table->double('pt_lainnya');
            $table->double('total_pot');
            $table->double('total_tj');
            $table->double('bruto');
            $table->double('netto');
            $table->double('pph21')->nullable();
            $table->enum('status', ['PENDING', 'BERHASIL']);
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
        Schema::dropIfExists('payrolls');
    }
}
