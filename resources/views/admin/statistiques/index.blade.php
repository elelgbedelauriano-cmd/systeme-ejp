@extends('layouts.admin')

@section('title', 'Statistiques')
@section('subtitle', 'Tableau de bord et analyses')

@section('content')
<div class="space-y-6">
    
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Statistiques</h1>
            <p class="text-gray-600">Analyses et tendances du système d'intégration</p>
        </div>
        <div class="flex space-x-3">
            <select id="timeframe" 
                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="week">Cette semaine</option>
                <option value="month">Ce mois</option>
                <option value="quarter">Ce trimestre</option>
                <option value="year">Cette année</option>
            </select>
        </div>
    </div>
    
    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Carte Nouveaux -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-user-friends text-blue-600 text-2xl"></i>
                </div>
                <span class="text-sm font-medium text-blue-600">Total</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $totalNouveaux }}</h3>
            <p class="text-gray-600">Nouveaux inscrits</p>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Cette semaine</span>
                    <span class="font-medium text-green-600">+12%</span>
                </div>
            </div>
        </div>
        
        <!-- Carte Aides -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-user-shield text-green-600 text-2xl"></i>
                </div>
                <span class="text-sm font-medium text-green-600">Actifs</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $totalAides }}</h3>
            <p class="text-gray-600">Aides à l'intégration</p>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Assignation moyenne</span>
                    <span class="font-medium text-gray-900">
                        {{ $totalNouveaux > 0 && $totalAides > 0 ? round($totalNouveaux / $totalAides, 1) : 0 }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Carte Programmes -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-calendar-alt text-purple-600 text-2xl"></i>
                </div>
                <span class="text-sm font-medium text-purple-600">Organisés</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $totalProgrammes }}</h3>
            <p class="text-gray-600">Programmes d'intégration</p>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Cette semaine</span>
                    <span class="font-medium text-gray-900">3</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Graphiques et tableaux -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Graphique d'évolution -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
                Évolution de la participation (semaine)
            </h3>
            <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                <div class="text-center">
                    <i class="fas fa-chart-line text-gray-300 text-5xl mb-4"></i>
                    <p class="text-gray-500">Graphique à implémenter</p>
                    <p class="text-sm text-gray-400">Utilisez Chart.js ou une autre librairie</p>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <p>Participation moyenne : <span class="font-medium">78%</span></p>
                <p>Tendance : <span class="text-green-600 font-medium">↑ 5% vs semaine dernière</span></p>
            </div>
        </div>
        
        <!-- Taux de rétention -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
                Taux de rétention (30 jours)
            </h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Nouveaux Actifs</span>
                        <span class="text-sm font-bold text-green-600">65%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-green-600 h-2.5 rounded-full" style="width: 65%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Nouveaux Moyens</span>
                        <span class="text-sm font-bold text-yellow-600">25%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-yellow-500 h-2.5 rounded-full" style="width: 25%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Nouveaux Inactifs</span>
                        <span class="text-sm font-bold text-red-600">10%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-red-600 h-2.5 rounded-full" style="width: 10%"></div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-lightbulb text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-blue-800">Recommandation</h4>
                        <div class="mt-1 text-sm text-blue-700">
                            <p>Focus sur les 10% inactifs pour améliorer le taux de rétention global.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tableau des meilleurs aides -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Top 5 des Aides</h3>
            <p class="mt-1 text-sm text-gray-500">Classement par taux de participation</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aide</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nouveaux</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Taux participation</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <!-- Données simulées - À remplacer par des vraies données -->
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <div class="ml-3">
                                    <div class="font-medium">Marie Dupont</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold">12</span> nouveaux
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: 92%"></div>
                                </div>
                                <span class="font-bold text-green-600">92%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Excellent
                            </span>
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <div class="ml-3">
                                    <div class="font-medium">Jean Martin</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold">8</span> nouveaux
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: 85%"></div>
                                </div>
                                <span class="font-bold text-green-600">85%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Très bon
                            </span>
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <div class="ml-3">
                                    <div class="font-medium">Sophie Leroy</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold">10</span> nouveaux
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                    <div class="bg-yellow-500 h-2 rounded-full" style="width: 72%"></div>
                                </div>
                                <span class="font-bold text-yellow-600">72%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Moyen
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <a href="{{ route('admin.aides.index') }}" 
               class="text-blue-600 hover:text-blue-900 font-medium">
                Voir tous les aides <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
    
    <!-- Résumé mensuel -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">
            Résumé mensuel
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4 border border-gray-200 rounded-lg">
                <div class="text-2xl font-bold text-blue-600">+{{ rand(5, 15) }}</div>
                <div class="text-sm text-gray-600">Nouveaux ce mois</div>
            </div>
            <div class="text-center p-4 border border-gray-200 rounded-lg">
                <div class="text-2xl font-bold text-green-600">{{ rand(75, 90) }}%</div>
                <div class="text-sm text-gray-600">Taux de participation</div>
            </div>
            <div class="text-center p-4 border border-gray-200 rounded-lg">
                <div class="text-2xl font-bold text-purple-600">{{ rand(8, 12) }}</div>
                <div class="text-sm text-gray-600">Programmes organisés</div>
            </div>
            <div class="text-center p-4 border border-gray-200 rounded-lg">
                <div class="text-2xl font-bold text-yellow-600">-{{ rand(1, 5) }}%</div>
                <div class="text-sm text-gray-600">Taux d'absentéisme</div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts pour les graphiques (exemple avec Chart.js) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Exemple de configuration pour un futur graphique
    const ctx = document.createElement('canvas');
    ctx.id = 'participationChart';
    
    // Ici tu pourras ajouter Chart.js plus tard
    console.log('Chart.js prêt à être implémenté');
    
    // Gestion du timeframe
    document.getElementById('timeframe').addEventListener('change', function() {
        console.log('Changement de période :', this.value);
        // Ici tu pourras recharger les données avec AJAX
    });
});
</script>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    alert('{{ session('success') }}');
});
</script>
@endif
@endsection