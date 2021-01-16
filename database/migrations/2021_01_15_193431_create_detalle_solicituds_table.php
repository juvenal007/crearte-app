<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_solicituds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ds_proyecto_id')->nullable();
            $table->foreign('ds_proyecto_id')->references('id')->on('proyectos')->onDelete('set null');
            $table->unsignedBigInteger('ds_cliente_id')->nullable();
            $table->foreign('ds_cliente_id')->references('id')->on('clientes')->onDelete('set null');
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
        Schema::dropIfExists('detalle_solicituds');
    }
}
