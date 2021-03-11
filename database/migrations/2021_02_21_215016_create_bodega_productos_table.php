<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBodegaProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodega_productos', function (Blueprint $table) {
            $table->id();
            $table->integer('bp_cantidad', 0);
            $table->decimal('bp_precio', 8, 2);
            $table->integer('bp_total', 0);
            $table->integer('bp_existencia', 0);            
            $table->unsignedBigInteger('bp_producto_id')->nullable();
            $table->foreign('bp_producto_id')->references('id')->on('productos')->onDelete('set null');
            $table->unsignedBigInteger('bp_ingreso_id')->nullable();
            $table->foreign('bp_ingreso_id')->references('id')->on('ingresos')->onDelete('set null');
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
        Schema::dropIfExists('bodega_productos');
    }
}
