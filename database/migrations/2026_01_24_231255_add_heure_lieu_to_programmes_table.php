<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programmes', function (Blueprint $table) {
            // Ajoute les colonnes manquantes
            $table->time('heure_debut')->nullable()->after('date_programme');
            $table->time('heure_fin')->nullable()->after('heure_debut');
            $table->string('lieu')->nullable()->after('heure_fin');
        });

        // Après avoir ajouté les colonnes, copie les données existantes
        // Copie l'heure de date_programme vers heure_debut pour les enregistrements existants
        DB::table('programmes')->whereNotNull('date_programme')->update([
            'heure_debut' => DB::raw('TIME(date_programme)')
        ]);

        // Optionnel : Met une heure par défaut pour les programmes sans heure
        DB::table('programmes')->whereNull('heure_debut')->update([
            'heure_debut' => '08:00:00'
        ]);
    }

    public function down(): void
    {
        Schema::table('programmes', function (Blueprint $table) {
            $table->dropColumn(['heure_debut', 'heure_fin', 'lieu']);
        });
    }
};