<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compras', function (Blueprint $table) {
            $table->id();
            $table->string('oc_guia_despacho', 20)->nullable(); 
            $table->unsignedBigInteger('oc_cotizacion_id')->nullable();
            $table->foreign('oc_cotizacion_id')->references('id')->on('cotizacions')->onDelete('set null');
            $table->unsignedBigInteger('oc_estado_id')->nullable();
            $table->foreign('oc_estado_id')->references('id')->on('estados')->onDelete('set null');            
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
        Schema::dropIfExists('orden_compras');
    }
}
