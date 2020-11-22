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
            $table->string('solicitud_catalogo_cantidad', 50);            
            $table->foreignId('solicituds_id')->constrained()->onDelete('cascade');
            $table->foreignId('catalogos_id')->constrained()->onDelete('cascade');
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
