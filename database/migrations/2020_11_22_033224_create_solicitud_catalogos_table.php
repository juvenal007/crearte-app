<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudCatalogosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_catalogos', function (Blueprint $table) {
            $table->id();
            $table->string('sc_cantidad', 50);
            $table->unsignedBigInteger('sc_solicitud_id')->nullable();
            $table->foreign('sc_solicitud_id')->references('id')->on('solicituds')->onDelete('set null');
            $table->unsignedBigInteger('sc_catalogo_id')->nullable();
            $table->foreign('sc_catalogo_id')->references('id')->on('catalogos')->onDelete('set null');
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
        Schema::dropIfExists('solicitud_catalogos');
    }
}
