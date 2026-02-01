<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Aide\ParticipationController;
use App\Http\Controllers\Aide\NouveauController;
use App\Http\Controllers\Admin\AideController;
use App\Http\Controllers\Admin\ProgrammeController;
use App\Http\Controllers\Admin\NouveauController as AdminNouveauController;
use App\Http\Controllers\Admin\StatistiqueController;
use App\Http\Controllers\Admin\DashboardController;

// Page d'accueil - Redirige selon l'état d'authentification
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }
        return redirect('/aide/dashboard');
    }
    return redirect('/login');
});

// Routes d'authentification
require __DIR__.'/auth.php';

// Redirection après login
Route::get('/dashboard', function () {
    $user = Auth::user();
    
    if (!$user) {
        return redirect('/login');
    }
    
    if ($user->role === 'admin') {
        return redirect('/admin/dashboard');
    }
    
    return redirect('/aide/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ==================== ROUTES AIDE ====================
Route::prefix('aide')->name('aide.')->middleware(['auth'])->group(function () {
    
    // Dashboard Aide - CHANGE : utilise le contrôleur
    Route::get('/dashboard', [\App\Http\Controllers\Aide\DashboardController::class, 'index'])
        ->name('dashboard');
    
    // ===== ROUTES POUR LES NOUVEAUX (COMPLÈTES) =====
    // Liste des nouveaux
    Route::get('/nouveaux', [NouveauController::class, 'index'])->name('nouveaux.index');
    
    // Création d'un nouveau
    Route::get('/nouveaux/create', [NouveauController::class, 'create'])->name('nouveaux.create');
    Route::post('/nouveaux', [NouveauController::class, 'store'])->name('nouveaux.store');
    
    // Visualisation
    Route::get('/nouveaux/{nouveau}', [NouveauController::class, 'show'])->name('nouveaux.show');
    
    // Édition
    Route::get('/nouveaux/{nouveau}/edit', [NouveauController::class, 'edit'])->name('nouveaux.edit');
    Route::put('/nouveaux/{nouveau}', [NouveauController::class, 'update'])->name('nouveaux.update');
    
    // Suppression
    Route::delete('/nouveaux/{nouveau}', [NouveauController::class, 'destroy'])->name('nouveaux.destroy');
    
    // Détails (page spéciale)
    Route::get('/nouveaux/{nouveau}/details', [NouveauController::class, 'details'])->name('nouveaux.details');
    
    // Historique
    Route::get('/nouveaux/{nouveau}/historique', [NouveauController::class, 'historique'])->name('nouveaux.historique');
    
    // AJOUTÉ : Stats d'un nouveau (pour le modal de suppression)
    Route::get('/nouveaux/{nouveau}/stats', [NouveauController::class, 'stats'])
        ->name('nouveaux.stats');
    
    // ===== ROUTES POUR LES PARTICIPATIONS =====
    // Liste des programmes - MODIFIÉ : avec paramètre optionnel
    Route::get('/participations/programmes/{nouveau?}', [ParticipationController::class, 'programmes'])
        ->name('participations.programmes');
    
    // Enregistrer une présence
    Route::post('/participations/enregistrer', [ParticipationController::class, 'enregistrer'])
        ->name('participations.enregistrer');
    
    // Historique des participations
    Route::get('/participations/{nouveau}/historique', [ParticipationController::class, 'historique'])
        ->name('participations.historique');
        
    // AJOUTÉ : Stats d'un nouveau (API)
    Route::get('/participations/{nouveau}/stats', [ParticipationController::class, 'stats'])
        ->name('participations.stats');
        
    // AJOUTÉ : Participations récentes
    Route::get('/participations/{nouveau}/recentes', [ParticipationController::class, 'recentes'])
        ->name('participations.recentes');
});

// ==================== ROUTES ADMIN ====================
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    // Dashboard Admin avec contrôleur
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Routes pour les aides
    Route::resource('aides', AideController::class)->parameters([
        'aides' => 'user'
    ]);
    
    // Routes supplémentaires pour aides
    Route::get('/aides/{user}/nouveaux', [AideController::class, 'nouveaux'])
        ->name('aides.nouveaux');
    
    Route::post('/aides/{user}/assign-nouveau', [AideController::class, 'assignNouveau'])
        ->name('aides.assignNouveau');
    
    Route::delete('/aides/{user}/remove-nouveau/{nouveau}', [AideController::class, 'removeNouveau'])
        ->name('aides.removeNouveau');
    
    Route::post('/aides/{user}/reset-password', [AideController::class, 'resetPassword'])
        ->name('aides.resetPassword');
    
    // Routes pour les programmes
    Route::resource('programmes', ProgrammeController::class);
    
    // Routes pour les nouveaux (admin)
Route::resource('nouveaux', AdminNouveauController::class)->parameters([
    'nouveaux' => 'nouveau'
]);
    
        // ===== ROUTES POUR LES STATISTIQUES (AVEC LE CONTROLLER) =====
    Route::prefix('statistiques')->name('statistiques.')->group(function () {
        // Page principale des statistiques
        Route::get('/', [StatistiqueController::class, 'index'])->name('index');
        
        // API pour récupérer les données AJAX
        Route::get('/data', [StatistiqueController::class, 'getData'])->name('data');
        
        // Export des données
        Route::get('/export', [StatistiqueController::class, 'export'])->name('export');
        
        // Détails des statistiques
        Route::get('/details/{type}', [StatistiqueController::class, 'details'])->name('details');
    });
    
    Route::get('/rapports', function() {
        $user = Auth::user();
        if ($user->role !== 'admin') abort(403);
        return "Page Rapports - À développer";
    })->name('rapports.index');
});