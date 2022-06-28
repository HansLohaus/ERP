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
            $table->bigInteger('gastable_id')->unsigned()->index();
            $table->string('gastable_type');
            $table->bigInteger('monto');
            $table->string('descrip', 100);
            $table->string('path');
            $table->boolean('reembolso');
            $table->date('fecha_gasto');
            $table->timestamps();// created_at, updated_at
            $table->softDeletes();//deleted_at
            $table->unique(['gastable_id','gastable_type']);
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
