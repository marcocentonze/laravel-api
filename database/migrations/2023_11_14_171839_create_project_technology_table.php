<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */


    public function up(): void
    {
        Schema::create('project_technology', function (Blueprint $table) {
            // $table->id();

            $table->primary(['project_id', 'technology_id']); // IMPEDISCE CHE SI POSSA ASSOCIARE DUE VOLTE LO STESSO PROGETTO E LA STESSA TECH (QUINDI EVITANDO PROGETTI CON DUE TECH UGUALI)

            $table->unsignedBigInteger('project_id'); // CREA LA COLONNA
            $table->foreign('project_id') // ASSEGNA LA COLONNA ALL'ID DI projects
                ->references('id')
                ->on('projects');

            $table->unsignedBigInteger('technology_id'); // CREA LA COLONNA
            $table->foreign('technology_id') // ASSEGNA LA COLONNA ALL'ID DI technologies
                ->references('id')
                ->on('technologies');

            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_technology');
    }
};
