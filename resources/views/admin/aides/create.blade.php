@extends('layouts.admin')

@section('title', 'Créer un Aide')
@section('subtitle', 'Ajouter un nouvel aide')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Nouvel Aide
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Remplissez les informations pour créer un nouvel aide
            </p>
        </div>
        
        <form method="POST" action="{{ route('admin.aides.store') }}" class="px-4 py-5 sm:p-6">
            @csrf
            
            <div class="space-y-6">
                <!-- Nom -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Nom complet *
                    </label>
                    <input type="text" name="name" id="name" required
                           class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm 
                                  sm:text-sm border-gray-300 rounded-md transition-all duration-200
                                  hover:border-blue-300"
                           placeholder="Ex: Jean Dupont">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email *
                    </label>
                    <input type="email" name="email" id="email" required
                           class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm 
                                  sm:text-sm border-gray-300 rounded-md transition-all duration-200
                                  hover:border-blue-300"
                           placeholder="exemple@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Mot de passe *
                    </label>
                    <input type="password" name="password" id="password" required
                           class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm 
                                  sm:text-sm border-gray-300 rounded-md transition-all duration-200
                                  hover:border-blue-300"
                           placeholder="Minimum 8 caractères">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Confirmation mot de passe -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        Confirmer le mot de passe *
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm 
                                  sm:text-sm border-gray-300 rounded-md transition-all duration-200
                                  hover:border-blue-300"
                           placeholder="Répétez le mot de passe">
                </div>
            </div>
            
            <!-- Boutons -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('admin.aides.index') }}" 
                   class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm 
                          font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 
                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                          transition-all duration-200">
                    Annuler
                </a>
                <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm 
                               text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                               transition-all duration-200 transform hover:-translate-y-0.5">
                    <i class="fas fa-save mr-2"></i> Créer l'aide
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Effets glassmorphism
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
    background: rgba(59, 130, 246, 0.05);
    border-radius: 0.5rem;
    padding: 0.5rem;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}
</style>
@endsection