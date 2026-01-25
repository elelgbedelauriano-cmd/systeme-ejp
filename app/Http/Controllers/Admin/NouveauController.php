<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nouveau;
use App\Models\User;
use Illuminate\Http\Request;

class NouveauController extends Controller
{
    public function index()
    {
        $nouveaux = Nouveau::with('aide')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.nouveaux.index', compact('nouveaux'));
    }
    
    public function create()
    {
        $aides = User::where('role', 'aide')->get();
        return view('admin.nouveaux.create', compact('aides'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'prenom' => 'required|string|max:100',
            'nom' => 'required|string|max:100',
            'email' => 'required|email|unique:nouveaux,email',
            'profession' => 'required|string|max:200',
            'fij' => 'required|string|max:50',
            'telephone' => 'nullable|string|max:20',
            'date_enregistrement' => 'required|date',
            'aide_id' => 'nullable|exists:users,id',
        ]);
        
        Nouveau::create([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'email' => $request->email,
            'profession' => $request->profession,
            'fij' => $request->fij,
            'telephone' => $request->telephone,
            'date_enregistrement' => $request->date_enregistrement,
            'aide_id' => $request->aide_id,
        ]);
        
        return redirect()->route('admin.nouveaux.index')
            ->with('success', 'Nouveau créé avec succès');
    }
    
    public function show(Nouveau $nouveau)
    {
        $participations = $nouveau->participations()
            ->with('programme')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.nouveaux.show', compact('nouveau', 'participations'));
    }
    
    public function edit(Nouveau $nouveau)
    {
        $aides = User::where('role', 'aide')->get();
        return view('admin.nouveaux.edit', compact('nouveau', 'aides'));
    }
    
    public function update(Request $request, Nouveau $nouveau)
    {
        $request->validate([
            'prenom' => 'required|string|max:100',
            'nom' => 'required|string|max:100',
            'email' => 'required|email|unique:nouveaux,email,' . $nouveau->id,
            'profession' => 'required|string|max:200',
            'fij' => 'required|string|max:50',
            'telephone' => 'nullable|string|max:20',
            'date_enregistrement' => 'required|date',
            'aide_id' => 'nullable|exists:users,id',
        ]);
        
        $nouveau->update([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'email' => $request->email,
            'profession' => $request->profession,
            'fij' => $request->fij,
            'telephone' => $request->telephone,
            'date_enregistrement' => $request->date_enregistrement,
            'aide_id' => $request->aide_id,
        ]);
        
        return redirect()->route('admin.nouveaux.show', $nouveau)
            ->with('success', 'Nouveau mis à jour');
    }
    
    public function destroy(Nouveau $nouveau)
    {
        $nouveau->delete();
        
        return redirect()->route('admin.nouveaux.index')
            ->with('success', 'Nouveau supprimé');
    }
}