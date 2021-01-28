<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion_productos', function (Blueprint $table) {
            $table->id();
            $table->integer('cp_cantidad');
            $table->decimal('cp_precio', 8, 2);
            $table->integer('cp_total');
            $table->unsignedBigInteger('cp_cotizacion_id')->nullable();
            $table->foreign('cp_cotizacion_id')->references('id')->on('cotizacions')->onDelete('set null');
            $table->unsignedBigInteger('cp_producto_id')->nullable();
            $table->foreign('cp_producto_id')->references('id')->on('productos')->onDelete('set null');
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
        Schema::dropIfExists('cotizacion_productos');
    }
}
