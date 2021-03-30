<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabajadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajadores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombres', 50);
            $table->string('apellidoP', 50);
            $table->string('apellidoM', 50);
            $table->string('rut', 15);
            $table->date('fecha_nac', 50);
            $table->string('direccion', 50);
            $table->string('cargo', 30);
            $table->string('profesion', 30);
            $table->string('sueldo', 45);
            $table->date('fecha_contrato');
            $table->string('fono', 15);
            $table->string('email', 50);
            $table->string('email_alt', 50);
            $table->string('numero_cuenta_banc', 50);
            $table->string('titular_cuenta_banc', 50);
            $table->string('banco', 50);
            $table->string('tipo_cuenta', 50);
            $table->string('afp', 50);
            $table->string('prevision', 50);
            $table->timestamps();// created_at, updated_at
            $table->softDeletes();//deleted_at
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabajadores');
    }
}