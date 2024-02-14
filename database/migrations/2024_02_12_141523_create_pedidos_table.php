<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->integer('id')->unsigned()->autoIncrement();
            $table->string('produto');
            $table->float('valor', 10, 2)->default(0);
            $table->datetime('data');
            $table->unsignedInteger('cliente_id');
            $table->unsignedInteger('pedido_status_id');
            $table->boolean('ativo')->nullable();

            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('pedido_status_id')->references('id')->on('pedido_status');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
