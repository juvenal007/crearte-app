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
            $table->integer('proveedor_rut', 0);
            $table->string('proveedor_dv', 1);
            $table->string('proveedor_nombre', 100);
            $table->string('proveedor_apellido_paterno', 100);
            $table->string('proveedor_apellido_materno', 100)->nullable();
            $table->string('proveedor_direccion', 100);
            $table->string('proveedor_telefono', 20);
            $table->string('proveedor_razon_social', 200);
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
