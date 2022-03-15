<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupUnitOfMeasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupo_unidade_medida', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('descricao');
            $table->integer('id_unidade_medida');
            $table->integer('id_filial');
            $table->string('unidade_base');
            $table->float('valor_convertido');
            $table->integer('id_usuario_cadastro');
            $table->char('status', 1);
            $table->dateTime('data_cadastro');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grupo_unidade_medida');
    }
}
