<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateUsersTable extends Migration
{
    use SoftDeletes;

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->integer('id_admin');
            $table->integer('id_cabang');
            $table->integer('id_divisi');
            $table->string('nama');
            $table->string('nip');
            $table->string('username');
            $table->string('status');
            $table->enum('roles', ['admin', 'user']);
            $table->text('alamat')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->text('company_logo')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->datetime('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
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
        Schema::dropIfExists('users');
    }
}
