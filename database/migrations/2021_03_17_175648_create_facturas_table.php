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
            $table->bigInteger('entidad_id')->unsigned()->index();
            $table->bigInteger('servicio_id')->unsigned()->index()->nullable();
            $table->Integer('folio');
            $table->Integer('tipo_dte');
            $table->date('fecha_emision');
            $table->string('total_reparto', 50)->nullable();
            $table->bigInteger('total_neto')->default(0);
            $table->bigInteger('total_exento')->default(0);
            $table->bigInteger('total_iva')->default(0);
            $table->bigInteger('total_monto_total');
            $table->date('fecha_recep')->nullable();
            $table->string('evento_recep', 50)->nullable();
            $table->string('cod_otro', 50)->nullable();
            $table->string('valor_otro', 50)->nullable();
            $table->string('tasa_otro', 50)->nullable();
            $table->enum('estado', ['pagado', 'impago', 'abono', 'anulado']);
            $table->timestamps();// created_at, updated_at
            $table->softDeletes();//deleted_at
        });
        Schema::table('facturas', function ($table) {
            $table->foreign('entidad_id')->references('id')->on('entidades')->onDelete('cascade');
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');
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
