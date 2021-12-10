<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
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
            $table->timestamps();
            //produtos tem nome, preço e quantidade em estoque, que pode ser negativa
            $table->string('nome');
            $table->decimal('preco', 8, 2);
            $table->integer('quantidade');

            $table->unsignedBigInteger('marca_id');
            $table->foreign('marca_id')->references('id')->on('marcas');
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
