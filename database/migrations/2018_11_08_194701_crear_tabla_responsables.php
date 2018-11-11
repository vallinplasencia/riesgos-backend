<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaResponsables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsables', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nombre', 100)->nullable(false);
            $table->string('funcion', 70)->nullable(false);
            $table->string('area', 70)->nullable(false);
            $table->string('direccion', 100)->nullable(false);
            $table->string('email', 100)->nullable(false);
//            $table->string('email', 100)->unique()->nullable(false);
            $table->date('fechaAlta')->nullable(false);
            $table->date('fechaBaja')->nullable(true);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('responsables');
    }
}
