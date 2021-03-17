<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalidaProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salida_productos', function (Blueprint $table) {
            $table->id();          
            $table->integer('sp_cantidad', 0);
            $table->decimal('sp_precio', 8, 2);
            $table->integer('sp_total', 0);                      
            $table->unsignedBigInteger('sp_producto_id')->nullable();
            $table->foreign('sp_producto_id')->references('id')->on('productos')->onDelete('set null');
            $table->unsignedBigInteger('sp_salida_id')->nullable();
            $table->foreign('sp_salida_id')->references('id')->on('salidas')->onDelete('set null');
            $table->unsignedBigInteger('sp_detalle_solicitud_id')->nullable();
            $table->foreign('sp_detalle_solicitud_id')->references('id')->on('detalle_solicituds')->onDelete('set null');
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
        Schema::dropIfExists('salida_productos');
    }
}
