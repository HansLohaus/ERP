<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoletasLiquidacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boletas_liquidaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('trabajador_id')->unsigned()->index();
            $table->string('descripcion', 50);
            $table->string('monto_total', 50);
            $table->string('monto_liquido', 50);
            $table->enum('boleta_liq', ['boleta', 'liquidacion']);
            $table->string('sueldo_base', 50)->nullable();
            $table->string('gratificaciones', 50)->nullable();
            $table->string('dias_trabajados', 50)->nullable();
            $table->string('desc_isapre', 50)->nullable();
            $table->string('desc_afp', 50)->nullable();
            $table->string('desc_seguro_cesantia', 50)->nullable();
            $table->string('impuesto_unico', 50)->nullable();
            $table->timestamps();// created_at, updated_at
            $table->softDeletes();//deleted_at
        });
        Schema::table('boletas_liquidaciones', function ($table) {
            $table->foreign('trabajador_id')->references('id')->on('trabajadores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boletas_liquidaciones');
    }
}
