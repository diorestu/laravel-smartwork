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
            $table->string('pay_code', 50);
            $table->string('pay_bulan', 2);
            $table->string('pay_tahun', 4);
            $table->double('pay_pokok');
            $table->double('bpjs_tk')->nullable();
            $table->double('bpjs_kes')->nullable();
            $table->double('total_pot');
            $table->double('total_tj');
            $table->double('bruto');
            $table->double('netto');
            $table->double('pph21')->nullable();
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
