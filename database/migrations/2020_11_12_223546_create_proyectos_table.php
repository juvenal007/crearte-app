<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->string('proyecto_nombre', 100);
            $table->string('proyecto_direccion', 250);
            $table->string('proyecto_descripcion', 250);
            $table->string('proyecto_telefono_ad', 16)->nullable();;
            $table->unsignedBigInteger('proyecto_centro_costo_id')->nullable();
            $table->foreign('proyecto_centro_costo_id')->references('id')->on('centro_costos')->onDelete('set null');
            $table->unsignedBigInteger('proyecto_estado_id')->nullable();
            $table->foreign('proyecto_estado_id')->references('id')->on('estados')->onDelete('set null');
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
        Schema::dropIfExists('proyectos');
    }
}
