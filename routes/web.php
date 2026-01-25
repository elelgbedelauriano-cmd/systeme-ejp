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
    
    // Dashboard Aide
    Route::get('/dashboard', function() {
        $user = Auth::user();
        if ($user->role !== 'aide') abort(403);
        return view('aide.dashboard');
    })->name('dashboard');
    
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
    
    // ===== ROUTES POUR LES PARTICIPATIONS =====
    // Liste des programmes
    Route::get('/participations/programmes', function() {
        $user = Auth::user();
        if ($user->role !== 'aide') abort(403);
        
       $programmes = App\Models\Programme::where('date_programme', '>=', now())
    ->where('date_programme', '<=', now()->addDays(7))
    ->orderBy('date_programme', 'asc')
    ->get();
        
        return view('aide.participations.programmes', compact('programmes'));
    })->name('participations.programmes');
    
    // Enregistrer une présence
    Route::post('/participations/enregistrer', [ParticipationController::class, 'enregistrer'])
        ->name('participations.enregistrer');
    
    // Historique des participations
    Route::get('/participations/{nouveau}/historique', [ParticipationController::class, 'historique'])
        ->name('participations.historique');
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
    
    // CORRECTION ICI : Enlève 'admin.' du nom car il est déjà dans le préfixe
    Route::post('/aides/{user}/reset-password', [AideController::class, 'resetPassword'])
        ->name('aides.resetPassword'); // CHANGÉ: 'admin.aides.resetPassword' → 'aides.resetPassword'
    
    // Routes pour les programmes
    Route::resource('programmes', ProgrammeController::class);
    
    // Routes pour les nouveaux (admin)
    Route::resource('nouveaux', AdminNouveauController::class);
    
    // Routes pour les statistiques
    Route::get('/statistiques', function() {
        $user = Auth::user();
        if ($user->role !== 'admin') abort(403);
        
        $totalNouveaux = App\Models\Nouveau::count();
        $totalAides = App\Models\User::where('role', 'aide')->count();
        $totalProgrammes = App\Models\Programme::count();
        
        $nouveauxSansAide = App\Models\Nouveau::whereNull('aide_id')->count();
        $programmesCeMois = App\Models\Programme::whereMonth('date_programme', now()->month)
            ->whereYear('date_programme', now()->year)
            ->count();
        
        $nouveauxCeMois = App\Models\Nouveau::whereMonth('date_enregistrement', now()->month)
            ->whereYear('date_enregistrement', now()->year)
            ->count();
        
        $derniersNouveaux = App\Models\Nouveau::with('aide')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        $derniersProgrammes = App\Models\Programme::orderBy('date_programme', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.statistiques.index', compact(
            'totalNouveaux', 
            'totalAides', 
            'totalProgrammes',
            'nouveauxSansAide',
            'programmesCeMois',
            'nouveauxCeMois',
            'derniersNouveaux',
            'derniersProgrammes'
        ));
    })->name('statistiques.index');
    
    Route::get('/rapports', function() {
        $user = Auth::user();
        if ($user->role !== 'admin') abort(403);
        return "Page Rapports - À développer";
    })->name('rapports.index');
});