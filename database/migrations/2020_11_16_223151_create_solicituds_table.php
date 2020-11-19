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
            $table->string('solicitud_codigo', 100);
            $table->string('solicitud_nombre', 50);
            $table->string('solicitud_descripcion', 200)->nullable();
            $table->string('solicitud_nombre_solicitante', 50)->nullable();
            $table->foreignId('estados_id')->constrained()->onDelete('cascade');
            $table->foreignId('proyectos_id')->constrained()->onDelete('cascade');            
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
