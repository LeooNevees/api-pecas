<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->integer('id_grupo_itens');
            $table->integer('id_unidade_medida');
            $table->integer('id_grupo_unidade_medida');
            $table->integer('id_filial');
            $table->boolean('item_compra');
            $table->boolean('item_venda');
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
        Schema::dropIfExists('produtos');
    }
}
