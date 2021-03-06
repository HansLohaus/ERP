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
            $table->enum('pago', ['C', 'A']);
            $table->date('fecha');
            $table->bigInteger('monto');
            $table->string('descrip_movimiento', 100)->nullable();
            $table->string('n_doc', 45)->nullable();
            $table->string('sucursal', 45)->nullable();
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
        Schema::dropIfExists('pagos');
    }
}
