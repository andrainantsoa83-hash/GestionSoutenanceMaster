<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('criteres', function (Blueprint $table) {
            $table->id('idCritere');

            $table->string('libelle');
            $table->text('description')->nullable();
            $table->boolean('actif')->default(true);

            $table->unsignedBigInteger('grille_evaluation_id');

            $table->foreign('grille_evaluation_id')
                  ->references('idGrille')
                  ->on('grille_evaluations')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('criteres');
    }
};