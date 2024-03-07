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
        Schema::table('taxonomia_suelo_caaguazus', function (Blueprint $table) {
            // Agregar nueva columna llamada 'nueva_columna' de tipo string
            $table->string('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taxonomia_suelo_caaguazus', function (Blueprint $table) {
            // Revertir la adición de la nueva columna
            $table->dropColumn('updated_at');
        });
    }
};
