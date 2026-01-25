@extends('layouts.admin')

@section('title', 'Ajouter un Nouveau')
@section('subtitle', 'Créer un nouveau compte')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-6">Nouveau Membre</h2>
        
        <form method="POST" action="{{ route('admin.nouveaux.store') }}">
            @csrf
            
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-2">Prénom *</label>
                        <input type="text" name="prenom" required 
                               class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Nom *</label>
                        <input type="text" name="nom" required 
                               class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>
                </div>
                
                <div>
                    <label class="block text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" required 
                           class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-2">Profession *</label>
                        <input type="text" name="profession" required 
                               class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">FIJ *</label>
                        <input type="text" name="fij" required 
                               class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-2">Assigner à un aide</label>
                        <select name="aide_id" class="w-full border border-gray-300 rounded px-3 py-2">
                            <option value="">-- Sélectionnez --</option>
                            @foreach($aides as $aide)
                                <option value="{{ $aide->id }}">{{ $aide->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Date d'enregistrement *</label>
                        <input type="date" name="date_enregistrement" required 
                               value="{{ date('Y-m-d') }}"
                               class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>
                </div>
            </div>
            
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('admin.nouveaux.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Créer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection