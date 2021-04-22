<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoletaLiquidacionPagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boleta_liquidacion_pago', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('boleta_liquidacion_id')->unsigned()->index();
            $table->bigInteger('pago_id')->unsigned()->index();
            $table->timestamps();// created_at, updated_at
            $table->softDeletes();//deleted_at
        });
        Schema::table('boleta_liquidacion_pago', function ($table) {
            $table->foreign('boleta_liquidacion_id')->references('id')->on('boletas_liquidaciones')->onDelete('cascade');
            $table->foreign('pago_id')->references('id')->on('pagos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boleta_liquidacion_pago');
    }
}
