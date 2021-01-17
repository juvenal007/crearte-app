<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('producto_material', 100);
            $table->string('producto_descripcion', 200);
            $table->unsignedBigInteger('producto_proveedor_id')->nullable();
            $table->foreign('producto_proveedor_id')->references('id')->on('proveedors')->onDelete('set null');
            $table->unsignedBigInteger('producto_unidad_id')->nullable();
            $table->foreign('producto_unidad_id')->references('id')->on('unidads')->onDelete('set null');
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
        Schema::dropIfExists('productos');
    }
}
