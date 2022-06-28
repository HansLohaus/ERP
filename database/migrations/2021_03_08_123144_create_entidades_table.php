<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_tipo_entidad')->unsigned()->index()->nullable();
            $table->string('rut', 15);
            $table->string('razon_social', 200);
            $table->string('nombre_fantasia', 50);
            $table->string('nombre_contacto_fin', 30)->nullable();
            $table->string('nombre_contacto_tec', 30)->nullable();
            $table->string('fono_contacto_fin', 15)->nullable();
            $table->string('fono_contacto_tec', 15)->nullable();
            $table->string('email_contacto_fin', 100)->nullable();
            $table->string('email_contacto_tec', 100)->nullable();
            $table->tinyInteger('activo')->default(1);
            $table->timestamps();// created_at, updated_at
            $table->softDeletes();//deleted_at
        });

        Schema::table('entidades', function ($table) {
            $table->foreign('id_tipo_entidad')->references('id')->on('tipo_entidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entidades');
    }
}
