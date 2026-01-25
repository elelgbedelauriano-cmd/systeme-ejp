<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('participations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nouveau_id')->constrained()->onDelete('cascade');
            $table->foreignId('programme_id')->constrained()->onDelete('cascade');
            $table->boolean('present')->default(false); // AJOUTÉ
            $table->string('statut')->nullable(); // "présent", "absent", "excuse"
            $table->text('motif_absence')->nullable();
            $table->foreignId('marque_par')->constrained('users');
            $table->timestamps();
            
            // Empêche les doublons
            $table->unique(['nouveau_id', 'programme_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('participations');
    }
};