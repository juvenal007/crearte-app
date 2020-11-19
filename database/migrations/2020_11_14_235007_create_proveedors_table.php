<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedors', function (Blueprint $table) {
            $table->id();
            $table->string('proveedor_rut', 20);
            $table->string('proveedor_nombre', 30);
            $table->string('proveedor_apellido_paterno', 25)->nullable();
            $table->string('proveedor_apellido_materno', 25)->nullable();
            $table->string('proveedor_direccion', 100);
            $table->string('proveedor_telefono', 20);
            $table->string('proveedor_razon_social', 100);
            $table->string('proveedor_giro', 100);
            $table->string('proveedor_ciudad', 20);
            $table->string('proveedor_email', 100);
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
        Schema::dropIfExists('proveedors');
    }
}
