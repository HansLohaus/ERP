<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGastosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gastos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('trabajador_id')->unsigned()->index();
            $table->bigInteger('monto');
            $table->string('descrip', 100);
            $table->timestamps();// created_at, updated_at
            $table->softDeletes();//deleted_at
        });
        Schema::table('gastos', function ($table) {
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
        Schema::dropIfExists('gastos');
    }
}
