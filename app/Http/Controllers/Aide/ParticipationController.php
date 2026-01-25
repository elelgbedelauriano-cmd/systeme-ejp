<?php

namespace App\Http\Controllers\Aide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Nouveau;
use App\Models\Programme;
use App\Models\Participation;

class ParticipationController extends Controller
{
    /**
     * Afficher la liste des programmes disponibles
     */
    public function programmes()
    {
        $user = Auth::user();
        
        // Récupère les programmes à venir et en cours
        $programmes = Programme::where('date_programme', '>=', now()->subDay())
            ->orderBy('date_programme', 'asc')
            ->paginate(10);
        
        // Récupère les nouveaux de l'aide
        $nouveaux = Nouveau::where('aide_id', $user->id)->get();
        
        return view('aide.participations.programmes', compact('programmes', 'nouveaux'));
    }
    
    /**
     * Marquer présence/absence pour un nouveau
     */
    public function marquer(Request $request, Nouveau $nouveau, Programme $programme)
    {
        // Vérification d'accès
        if ($nouveau->aide_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }
        
        return view('aide.participations.marquer', compact('nouveau', 'programme'));
    }
    
    /**
     * Enregistrer la présence/absence
     */
    public function enregistrer(Request $request)
    {
        $request->validate([
            'nouveau_id' => 'required|exists:nouveaux,id',
            'programme_id' => 'required|exists:programmes,id',
            'present' => 'required|boolean',
            'motif_absence' => 'nullable|string|max:500',
        ]);
        
        // Vérifier que le nouveau appartient à l'aide
        $nouveau = Nouveau::findOrFail($request->nouveau_id);
        if ($nouveau->aide_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }
        
        // Créer ou mettre à jour la participation
        $participation = Participation::updateOrCreate(
            [
                'nouveau_id' => $request->nouveau_id,
                'programme_id' => $request->programme_id,
                'aide_id' => Auth::id(),
            ],
            [
                'present' => $request->present,
                'motif_absence' => $request->present ? null : $request->motif_absence,
                'enregistre_le' => now(),
            ]
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Participation enregistrée avec succès.',
            'participation' => $participation
        ]);
    }
    
    /**
     * Historique des participations avec filtre timeframe
     */
    public function historique(Request $request, Nouveau $nouveau)
    {
        // Vérification d'accès
        if ($nouveau->aide_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }
        
        // Détermine le timeframe (semaine/mois)
        $timeframe = $request->get('timeframe', 'semaine');
        
        if ($timeframe === 'semaine') {
            $dateDebut = now()->startOfWeek();
            $dateFin = now()->endOfWeek();
        } else {
            $dateDebut = now()->startOfMonth();
            $dateFin = now()->endOfMonth();
        }
        
        // Récupère les participations
        $participations = Participation::where('nouveau_id', $nouveau->id)
            ->whereBetween('created_at', [$dateDebut, $dateFin])
            ->with('programme')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        // Statistiques
        $stats = [
            'total' => $participations->count(),
            'present' => $participations->where('present', true)->count(),
            'absent' => $participations->where('present', false)->count(),
            'taux' => $participations->count() > 0 
                ? round(($participations->where('present', true)->count() / $participations->count()) * 100, 1)
                : 0,
        ];
        
        return view('aide.participations.historique', compact(
            'nouveau', 'participations', 'stats', 'timeframe'
        ));
    }
}