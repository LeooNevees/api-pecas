<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome_completo');
            $table->char('documento', 14)->unique();
            $table->string('login');
            $table->string('password');
            $table->string('tipo');
            $table->string('email');
            $table->char('telefone', 11);
            $table->integer('id_filial')->nullable();
            $table->integer('acesso_modulos')->nullable();
            $table->char('status', 1);
            $table->dateTime('data_cadastro');
            $table->rememberToken();
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
        Schema::dropIfExists('usuarios');
    }
}
