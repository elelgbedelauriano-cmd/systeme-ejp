@extends('layouts.admin') {{-- CHANGÉ : layouts.aide → layouts.admin --}}

@section('title', 'Modifier ' . $user->name) {{-- CHANGÉ : $nouveau → $user --}}
@section('subtitle', 'Modification des informations de l\'aide')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-8">
            <div class="flex items-center">
                <div class="h-14 w-14 rounded-full bg-white/20 flex items-center justify-center">
                    <i class="fas fa-user-edit text-white text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h1 class="text-2xl font-bold text-white">Modifier l'Aide</h1>
                    <p class="text-yellow-100">{{ $user->name }}</p> {{-- CHANGÉ : $nouveau → $user --}}
                </div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('admin.aides.update', $user) }}" {{-- CHANGÉ : $nouveau → $user --}}
              class="px-6 py-8 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Nom -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nom complet *
                </label>
                <input type="text" name="name" id="name" required
                       value="{{ old('name', $user->name) }}" {{-- CHANGÉ : $nouveau → $user --}}
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg 
                              focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 
                              transition-all duration-200 hover:border-yellow-400"
                       placeholder="Ex: Jean Dupont">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email *
                </label>
                <input type="email" name="email" id="email" required
                       value="{{ old('email', $user->email) }}" {{-- CHANGÉ : $nouveau → $user --}}
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg 
                              focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 
                              transition-all duration-200 hover:border-yellow-400"
                       placeholder="exemple@email.com">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Téléphone -->
            <div>
                <label for="telephone" class="block text-sm font-medium text-gray-700 mb-2">
                    Téléphone (optionnel)
                </label>
                <input type="tel" name="telephone" id="telephone"
                       value="{{ old('telephone', $user->telephone) }}" {{-- CHANGÉ : $nouveau → $user --}}
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg 
                              focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 
                              transition-all duration-200 hover:border-yellow-400"
                       placeholder="Ex: +229 XX XX XX XX">
                @error('telephone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Si tu veux permettre de changer le mot de passe -->
            <div class="pt-4 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Changer le mot de passe (optionnel)</h3>
                <div class="space-y-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Nouveau mot de passe
                        </label>
                        <input type="password" name="password" id="password"
                               class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg 
                                      focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 
                                      transition-all duration-200 hover:border-yellow-400"
                               placeholder="Laissez vide pour ne pas modifier">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirmer le mot de passe
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg 
                                      focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 
                                      transition-all duration-200 hover:border-yellow-400"
                               placeholder="Confirmez le nouveau mot de passe">
                    </div>
                </div>
            </div>
            
            <!-- Boutons -->
            <div class="flex justify-end space-x-4 pt-6">
                <a href="{{ route('admin.aides.show', $user) }}" {{-- CHANGÉ : $nouveau → $user --}}
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 
                          hover:bg-gray-50 transition-colors duration-200 font-medium">
                    Annuler
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 
                               text-white rounded-lg hover:from-yellow-600 hover:to-yellow-700 
                               transition-all duration-200 shadow-lg hover:shadow-xl font-medium
                               transform hover:-translate-y-0.5">
                    <i class="fas fa-save mr-2"></i> Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Effets glassmorphism sur les inputs
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input').forEach(element => {
        element.addEventListener('focus', () => {
            element.parentElement.classList.add('glassmorphism-input');
        });
        
        element.addEventListener('blur', () => {
            element.parentElement.classList.remove('glassmorphism-input');
        });
    });
});
</script>

<style>
.glassmorphism-input {
    background: rgba(245, 158, 11, 0.05);
    border-radius: 0.75rem;
    padding: 0.75rem;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
}
</style>
@endsection