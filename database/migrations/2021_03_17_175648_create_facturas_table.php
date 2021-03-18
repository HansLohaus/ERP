<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tipo_entidades_id')->unsigned()->index();
            $table->bigInteger('servicio_id')->unsigned()->index();
            $table->Integer('folio');
            $table->Integer('tipo_dte');
            $table->date('fecha_emision');
            $table->bigInteger('total_neto')->default(0);
            $table->bigInteger('total_exento')->default(0);
            $table->bigInteger('total_iva')->default(0);
            $table->bigInteger('total_monto_total');
            $table->enum('estado', ['pagado', 'impago', 'abono']);
            $table->timestamps();// created_at, updated_at
            $table->softDeletes();//deleted_at
        });
        Schema::table('facturas', function ($table) {
            $table->foreign('tipo_entidades_id')->references('id')->on('tipo_entidades');
            $table->foreign('servicio_id')->references('id')->on('servicios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturas');
    }
}
