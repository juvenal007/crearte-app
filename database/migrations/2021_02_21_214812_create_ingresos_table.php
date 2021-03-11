<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->id();         
            $table->unsignedBigInteger('ingreso_oc_id')->nullable();
            $table->foreign('ingreso_oc_id')->references('id')->on('orden_compras')->onDelete('set null');
            $table->unsignedBigInteger('ingreso_bodega_id')->nullable();
            $table->foreign('ingreso_bodega_id')->references('id')->on('bodegas')->onDelete('set null');
            $table->unsignedBigInteger('ingreso_ds_id')->nullable();
            $table->foreign('ingreso_ds_id')->references('id')->on('detalle_solicituds')->onDelete('set null');
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
        Schema::dropIfExists('ingresos');
    }
}
