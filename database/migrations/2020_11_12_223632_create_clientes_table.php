<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->integer('cliente_rut', 0);
            $table->string('cliente_dv', 1);
            $table->string('cliente_nombre', 100);
            $table->string('cliente_apellido_paterno', 100);
            $table->string('cliente_apellido_materno', 100)->nullable();;
            $table->string('cliente_telefono', 20)->nullable();;
            $table->string('cliente_direccion', 100)->nullable();;
            $table->string('cliente_genero', 20)->nullable();;
            $table->unsignedBigInteger('cliente_proyecto_id')->nullable();
            $table->foreign('cliente_proyecto_id')->references('id')->on('proyectos')->onDelete('set null');
            $table->unsignedBigInteger('cliente_estado_id')->nullable();
            $table->foreign('cliente_estado_id')->references('id')->on('estados')->onDelete('set null');
            $table->softDeletes('deleted_at', 0);
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
        Schema::dropIfExists('clientes');
    }
}
