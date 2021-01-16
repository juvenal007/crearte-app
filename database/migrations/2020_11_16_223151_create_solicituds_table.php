<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicituds', function (Blueprint $table) {
            $table->id();
            $table->string('solicitud_nombre', 100);
            $table->string('solicitud_descripcion', 200)->nullable();
            $table->string('solicitud_nombre_solicitante', 150)->nullable();
            $table->unsignedBigInteger('solicitud_estado_id')->nullable();
            $table->foreign('solicitud_estado_id')->references('id')->on('estados')->onDelete('set null');
            $table->unsignedBigInteger('solicitud_detalle_solicitud_id')->nullable();
            $table->foreign('solicitud_detalle_solicitud_id')->references('id')->on('detalle_solicituds')->onDelete('set null');
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
        Schema::dropIfExists('solicituds');
    }
}
