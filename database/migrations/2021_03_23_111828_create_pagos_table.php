<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('factura_id')->unsigned()->index();
            $table->bigInteger('boleta_liquidacion_id')->unsigned()->index();
            $table->enum('ine', ['ingreso', 'egreso']);
            $table->date('fecha_pago');
            $table->bigInteger('monto');
            $table->bigInteger('monto_total_transf');
            $table->string('descrip_movimiento', 100)->nullable();
            $table->timestamps();// created_at, updated_at
            $table->softDeletes();//deleted_at
            
        });

        Schema::table('pagos', function ($table) {
            $table->foreign('factura_id')->references('id')->on('facturas')->onDelete('cascade');
            $table->foreign('boleta_liquidacion_id')->references('id')->on('boletas_liquidaciones')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos');
    }
}