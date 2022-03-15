<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreatePayrollDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_parents', function (Blueprint $table) {
            $table->id();
            $table->integer('id_admin');
            $table->integer('pay_code');
            $table->integer('pay_bulan');
            $table->integer('pay_tahun');
            $table->string('pay_desc');
            $table->enum('payroll_status', ['PENDING', 'BERHASIL']);
            $table->dateTime('payroll_terima_date')->nullable();
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
        Schema::dropIfExists('payroll_parents');
    }
}
