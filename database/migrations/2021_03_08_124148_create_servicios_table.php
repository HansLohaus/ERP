<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tipo_entidad_id')->unsigned()->index();
            $table->string('nombre', 50);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->enum('tipo', ['servicio', 'proyecto']);
            $table->enum('estado', ['activo', 'inactivo']);
            $table->string('numero_propuesta', 30)->nullable();
            $table->string('condicion_pago', 30)->nullable();
            $table->timestamps();// created_at, updated_at
            $table->softDeletes();//deleted_at
        });
        Schema::table('servicios', function ($table) {
            $table->foreign('tipo_entidad_id')->references('id')->on('tipo_entidades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios');
    }
}
