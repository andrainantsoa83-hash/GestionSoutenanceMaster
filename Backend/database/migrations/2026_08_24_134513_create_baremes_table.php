<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('baremes', function (Blueprint $table) {
            $table->id('idBareme');

            $table->string('nom');
            $table->decimal('note_min', 5, 2);
            $table->decimal('note_max', 5, 2);
            $table->text('description')->nullable();

            $table->unsignedBigInteger('critere_id');

            $table->foreign('critere_id')
                  ->references('idCritere')
                  ->on('criteres')
                  ->onDelete('cascade');

            // Un critère possède un seul barème
            $table->unique('critere_id');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baremes');
    }
};