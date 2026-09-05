<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grille_evaluations', function (Blueprint $table) {
            $table->id('idGrille');

            $table->string('nom');
            $table->text('description')->nullable();
            $table->string('statut');

            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('type_master_id');

            $table->foreign('session_id')
                  ->references('idSession')
                  ->on('soutenance_sessions')
                  ->onDelete('cascade');
            $table->foreign('type_master_id')
                  ->references('idType')
                  ->on('type_masters')
                  ->onDelete('cascade');

            // Une seule grille pour un type de Master dans une session
            $table->unique(['session_id', 'type_master_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grille_evaluations');
    }
};