<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soils', function (Blueprint $table) {
            $table->id();
            $table->string('cultivo');
            $table->float('ph');
            $table->float('mo');
            $table->float('al3');
            $table->float('fosforo');
            $table->float('precipitacion_anual');
            $table->float('temperatura');
            $table->float('humedad');
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
        Schema::dropIfExists('soils');
    }
};
