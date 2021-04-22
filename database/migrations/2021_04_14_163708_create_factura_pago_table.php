<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaPagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_pago', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('factura_id')->unsigned()->index();
            $table->bigInteger('pago_id')->unsigned()->index();
            $table->timestamps();// created_at, updated_at
            $table->softDeletes();//deleted_at
        });
        Schema::table('factura_pago', function ($table) {
            $table->foreign('factura_id')->references('id')->on('facturas')->onDelete('cascade');
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
        Schema::dropIfExists('factura_pago');
    }
}
