<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacions', function (Blueprint $table) {
            $table->id();
            $table->integer('cotizacion_codigo', 0);         
            $table->integer('cotizacion_neto', 0);          
            $table->integer('cotizacion_iva', 0);        
            $table->integer('cotizacion_total', 0);   
            $table->date('cotizacion_fecha_emision')->nullable();      
            $table->date('cotizacion_fecha_vigencia')->nullable();       
            $table->foreignId('solicituds_id')->constrained()->onDelete('cascade');
            $table->foreignId('proveedors_id')->constrained()->onDelete('cascade');
            $table->foreignId('estados_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('cotizacions');
    }
}
