<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoEntidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_entidades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('entidades_id')->unsigned()->index();
            $table->enum('tipo', ['cliente', 'proveedor']);
        });
        Schema::table('tipo_entidades', function ($table) {
            $table->foreign('entidades_id')->references('id')->on('entidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_entidades');
    }
}
