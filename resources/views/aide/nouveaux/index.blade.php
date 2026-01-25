<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Nouveaux - Aide EJP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="md:flex">
        <!-- Sidebar -->
        <div class="bg-blue-800 text-white md:w-64">
            <div class="p-4">
                <h1 class="text-xl font-bold">
                    <i class="fas fa-hands-helping mr-2"></i>Aide EJP
                </h1>
                <p class="text-blue-200 text-sm">Bienvenue, {{ Auth::user()->name }}</p>
            </div>
            
            <nav class="mt-4">
                <a href="{{ route('aide.dashboard') }}" 
                   class="block py-3 px-4 hover:bg-blue-700 {{ request()->routeIs('aide.dashboard') ? 'bg-blue-700 border-r-4 border-yellow-400' : '' }}">
                    <i class="fas fa-home mr-3"></i> Accueil
                </a>
                <a href="{{ route('aide.nouveaux.index') }}" 
                   class="block py-3 px-4 hover:bg-blue-700 {{ request()->routeIs('aide.nouveaux.*') ? 'bg-blue-700 border-r-4 border-yellow-400' : '' }}">
                    <i class="fas fa-users mr-3"></i> Nouveaux
                </a>
            </nav>
            
            <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-blue-700">
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded flex items-center justify-center">
                    <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                </button>
            </form>
        </div>
        
        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-6">
            <div class="mb-6">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
                    <i class="fas fa-users mr-2"></i>Gestion des Nouveaux
                </h2>
                <p class="text-gray-600">Liste complète de vos nouveaux avec actions</p>
            </div>
            
            <!-- Bouton d'ajout -->
            <div class="mb-6">
                <a href="{{ route('aide.nouveaux.create') }}" 
                   class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg shadow">
                    <i class="fas fa-user-plus mr-2"></i> Ajouter un Nouveau
                </a>
            </div>
            
            <!-- Liste des nouveaux -->
            <div class="space-y-4">
                @php
                    // Vérifie si $nouveaux existe, sinon crée une collection vide
                    $nouveauxList = $nouveaux ?? collect();
                @endphp
                
                @forelse($nouveauxList as $nouveau)
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <!-- Informations de base -->
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                        <span class="font-bold text-blue-700 text-lg">
                                            {{ substr($nouveau->prenom ?? '', 0, 1) }}{{ substr($nouveau->nom ?? '', 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800">
                                            {{ $nouveau->prenom ?? '' }} {{ $nouveau->nom ?? '' }}
                                        </h3>
                                        <div class="flex items-center text-gray-600 mt-1">
                                            <i class="fas fa-briefcase mr-2"></i>
                                            <span>{{ $nouveau->profession ?? 'Non spécifié' }}</span>
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-envelope mr-2"></i>
                                            <span>{{ $nouveau->email ?? '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                           <!-- Boutons d'action -->
<div class="flex flex-col sm:flex-row gap-3">
    <!-- Bouton 1: Détails -->
    <a href="{{ route('aide.nouveaux.details', $nouveau) }}" 
       class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg">
        <i class="fas fa-info-circle mr-2"></i> Détails
    </a>
    
    <!-- AJOUTE CE BOUTON : -->
    <a href="{{ route('aide.participations.programmes') }}" 
       class="inline-flex items-center justify-center px-5 py-2.5 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg">
        <i class="fas fa-calendar-check mr-2"></i> Présence
    </a>
</div>
                        
                        <!-- Barre de progression du statut -->
                        <div class="mt-6">
                            @php
                                $statut = $nouveau->statut ?? ['label' => 'inactif', 'pourcentage' => 0];
                                $width = $statut['pourcentage'] ?? 0;
                                $color = $statut['couleur'] ?? 'red';
                            @endphp
                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                <span>Participation: {{ $statut['pourcentage'] ?? 0 }}%</span>
                                <span class="font-medium">{{ ucfirst($statut['label'] ?? 'inactif') }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="h-2.5 rounded-full 
                                    @if($color === 'green') bg-green-500
                                    @elseif($color === 'yellow') bg-yellow-500
                                    @else bg-red-500 @endif" 
                                    style="width: {{ min($width, 100) }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-white rounded-xl shadow">
                        <i class="fas fa-users text-gray-300 text-5xl mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">Aucun nouveau</h3>
                        <p class="text-gray-500 mb-6">Commencez par ajouter des nouveaux à suivre</p>
                        <a href="{{ route('aide.nouveaux.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg shadow inline-flex items-center">
                            <i class="fas fa-user-plus mr-2"></i> Ajouter votre premier nouveau
                        </a>
                    </div>
                @endforelse
                
                <!-- Pagination - Version sécurisée -->
                @if(isset($nouveaux) && method_exists($nouveaux, 'hasPages') && $nouveaux->hasPages())
                    <div class="mt-6">
                        {{ $nouveaux->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>