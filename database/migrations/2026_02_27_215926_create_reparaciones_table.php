<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReparacionesTable extends Migration
{
    public function up()
{
    Schema::create('reparaciones', function (Blueprint $table) {
        $table->increments('id');
        $table->string('etiqueta');
        $table->unsignedInteger('cliente_id');
        $table->string('equipo');
        $table->text('problema');
        $table->text('encontrado')->nullable();
        $table->string('accesorios')->nullable();
        $table->enum('estado', ['pendiente', 'proceso', 'terminado'])->default('pendiente');
        $table->date('fecha_ingreso');
        $table->date('fecha_salida')->nullable();
        $table->string('responsable');
        $table->timestamps();

        $table->foreign('cliente_id')
              ->references('id')
              ->on('customers')
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reparaciones');
    }
}
