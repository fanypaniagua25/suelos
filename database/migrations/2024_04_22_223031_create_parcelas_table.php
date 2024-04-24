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
    Schema::create('parcelas', function (Blueprint $table) {
        $table->id();
        $table->geometry('geometria'); // Tipo 'geometry' para PostgreSQL o 'POLYGON' para MySQL
        $table->unsignedBigInteger('cultivo_id');
        $table->foreign('cultivo_id')->references('id')->on('cultivos');
        $table->date('fecha_siembra');
        $table->date('fecha_cosecha');
        $table->text('otros_datos')->nullable();
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
        Schema::dropIfExists('parcelas');
    }
};
