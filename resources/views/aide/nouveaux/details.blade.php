<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails - {{ $nouveau->full_name }} - Aide Intégration</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .info-card {
            transition: all 0.3s ease;
        }
        .info-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }
        .tab-active {
            border-bottom: 3px solid #3B82F6;
            color: #1E40AF;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="md:flex">
        <!-- Sidebar -->
        <div class="bg-blue-800 text-white md:w-64">
            <div class="p-4">
                <h1 class="text-xl font-bold">
                    <i class="fas fa-hands-helping mr-2"></i>Aide à Intégration
                </h1>
                <p class="text-blue-200 text-sm">Bienvenue, {{ Auth::user()->name }}</p>
            </div>
            
            <nav class="mt-4">
                <a href="{{ route('aide.dashboard') }}" 
                   class="block py-3 px-4 hover:bg-blue-700 {{ request()->routeIs('aide.dashboard') ? 'bg-blue-700' : '' }}">
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
            <!-- En-tête avec navigation -->
            <div class="mb-6">
                <a href="{{ route('aide.nouveaux.index') }}" class="text-blue-600 hover:text-blue-800 inline-flex items-center mb-4">
                    <i class="fas fa-arrow-left mr-2"></i> Retour à la liste
                </a>
                
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
                            <i class="fas fa-user-circle mr-2"></i>{{ $nouveau->full_name }}
                        </h2>
                        <div class="flex items-center text-gray-600 mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                @if($nouveau->statut['label'] === 'actif') bg-green-100 text-green-800
                                @elseif($nouveau->statut['label'] === 'moyen') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                <i class="fas fa-chart-line mr-1"></i>
                                {{ ucfirst($nouveau->statut['label']) }} ({{ $nouveau->statut['pourcentage'] }}%)
                            </span>
                            <span class="mx-3 text-gray-300">•</span>
                            <span>Ajouté le {{ $nouveau->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="flex space-x-3 mt-4 md:mt-0">
                        <a href="{{ route('aide.nouveaux.edit', $nouveau) }}" 
                           class="inline-flex items-center px-4 py-2 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 rounded-lg">
                            <i class="fas fa-edit mr-2"></i> Modifier
                        </a>
                        <button onclick="showPresenceModal()"
                                class="inline-flex items-center px-4 py-2 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg">
                            <i class="fas fa-calendar-check mr-2"></i> Marquer présence
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Tabs -->
            <div class="border-b border-gray-200 mb-6">
                <nav class="flex space-x-8">
                    <button id="tab-infos" 
                            class="py-3 px-1 font-medium text-gray-500 hover:text-gray-700 tab-active"
                            onclick="showTab('infos')">
                        <i class="fas fa-user mr-2"></i>Informations personnelles
                    </button>
                    <button id="tab-historique"
                            class="py-3 px-1 font-medium text-gray-500 hover:text-gray-700"
                            onclick="showTab('historique')">
                        <i class="fas fa-history mr-2"></i>Historique de participation
                    </button>
                </nav>
            </div>
            
            <!-- Contenu Tab 1: Informations personnelles -->
            <div id="content-infos" class="space-y-6">
                <!-- Carte principale -->
                <div class="info-card bg-white rounded-xl shadow-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Informations personnelles -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-4">
                                <i class="fas fa-id-card mr-2"></i>Informations personnelles
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Nom complet</label>
                                    <p class="mt-1 text-gray-900 font-medium">{{ $nouveau->full_name }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Email</label>
                                    <p class="mt-1 text-gray-900">{{ $nouveau->email }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Profession</label>
                                    <p class="mt-1 text-gray-900">{{ $nouveau->profession }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Informations administratives -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-4">
                                <i class="fas fa-file-alt mr-2"></i>Informations administratives
                            </h3>
                            
                           <div>
    <label for="fij" class="block text-sm font-medium text-gray-700 mb-2">
        Famille d'Impact Jeune (FIJ) <span class="text-red-500">*</span>
    </label>
    <input type="text" id="fij" name="fij" required
           class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
           placeholder="Ex: Famille Jean, Famille Marie, etc.">
    <p class="text-gray-500 text-xs mt-1">Nom de la famille d'impact du jeune</p>
    @error('fij')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Date d'enregistrement</label>
                                    <p class="mt-1 text-gray-900">{{ \Carbon\Carbon::parse($nouveau->date_enregistrement)->format('d/m/Y') }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Assigné à</label>
                                    <p class="mt-1 text-gray-900">Vous ({{ Auth::user()->name }})</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bouton modification -->
                    <div class="mt-8 pt-6 border-t">
                        <a href="{{ route('aide.nouveaux.edit', $nouveau) }}" 
                           class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="fas fa-edit mr-2"></i> Modifier les informations
                        </a>
                    </div>
                </div>
                
                <!-- Statistiques rapides -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="info-card bg-white p-5 rounded-xl shadow">
                        <div class="text-2xl font-bold text-blue-600">
                            {{ $nouveau->participations->count() }}
                        </div>
                        <div class="text-sm text-gray-600">Programmes</div>
                    </div>
                    
                    <div class="info-card bg-white p-5 rounded-xl shadow border-l-4 border-green-500">
                        <div class="text-2xl font-bold text-green-600">
                            {{ $nouveau->participations->where('present', true)->count() }}
                        </div>
                        <div class="text-sm text-gray-600">Présences</div>
                    </div>
                    
                    <div class="info-card bg-white p-5 rounded-xl shadow border-l-4 border-red-500">
                        <div class="text-2xl font-bold text-red-600">
                            {{ $nouveau->participations->where('present', false)->count() }}
                        </div>
                        <div class="text-sm text-gray-600">Absences</div>
                    </div>
                    
                    <div class="info-card bg-white p-5 rounded-xl shadow border-l-4 border-purple-500">
                        <div class="text-2xl font-bold text-purple-600">
                            {{ $nouveau->statut['pourcentage'] }}%
                        </div>
                        <div class="text-sm text-gray-600">Taux de présence</div>
                    </div>
                </div>
            </div>
            
            <!-- Contenu Tab 2: Historique -->
            <div id="content-historique" class="space-y-6 hidden">
                <!-- Filtres -->
                <div class="bg-white p-5 rounded-xl shadow">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="font-bold text-gray-800 mb-2">Filtrer l'historique</h3>
                            <div class="flex flex-wrap gap-3">
                                <select class="border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option>Cette semaine</option>
                                    <option>Ce mois</option>
                                    <option>Trimestre</option>
                                    <option>Tout l'historique</option>
                                </select>
                                <select class="border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option>Tous les statuts</option>
                                    <option>Présents uniquement</option>
                                    <option>Absents uniquement</option>
                                </select>
                            </div>
                        </div>
                        <button class="px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100">
                            <i class="fas fa-download mr-2"></i> Exporter
                        </button>
                    </div>
                </div>
                
                <!-- Liste des participations -->
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Programme
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Statut
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Motif d'absence
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Enregistré le
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($nouveau->participations->sortByDesc('created_at') as $participation)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-medium text-gray-900">
                                                {{ $participation->programme->titre ?? 'Programme inconnu' }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $participation->programme->description ?? '' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $participation->created_at->format('d/m/Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $participation->created_at->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($participation->present)
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    <i class="fas fa-check mr-1"></i> Présent
                                                </span>
                                            @else
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    <i class="fas fa-times mr-1"></i> Absent
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $participation->motif_absence ?? '—' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $participation->enregistre_le->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                            <i class="fas fa-history text-gray-300 text-4xl mb-3"></i>
                                            <p class="text-lg">Aucune participation enregistrée</p>
                                            <p class="text-sm mt-2">Les participations apparaîtront ici</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Graphique (simplifié) -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-bold text-gray-800 mb-4">Évolution de la participation</h3>
                    <div class="h-64 flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg">
                        <div class="text-center text-gray-500">
                            <i class="fas fa-chart-line text-3xl mb-3"></i>
                            <p>Graphique des participations</p>
                            <p class="text-sm">(À implémenter avec Chart.js)</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Modal pour marquer présence (similaire à index.blade.php) -->
    <div id="presenceModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-2xl w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Marquer présence/absence</h3>
                    <button onclick="closePresenceModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
                
                <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-user-circle text-blue-500 text-2xl mr-3"></i>
                        <div>
                            <div class="font-bold text-blue-800">{{ $nouveau->full_name }}</div>
                            <div class="text-blue-700 text-sm">{{ $nouveau->profession }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="border rounded-lg p-4 hover:border-blue-300 cursor-pointer" onclick="selectProgrammeForDetails(1)">
                        <div class="flex justify-between items-center">
                            <div>
                                <h4 class="font-bold text-gray-800">Culte de Jeunesse</h4>
                                <p class="text-gray-600 text-sm">Vendredi 24 Janvier • 19h00</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </div>
                    </div>
                    
                    <div class="border rounded-lg p-4 hover:border-blue-300 cursor-pointer" onclick="selectProgrammeForDetails(2)">
                        <div class="flex justify-between items-center">
                            <div>
                                <h4 class="font-bold text-gray-800">Étude Biblique</h4>
                                <p class="text-gray-600 text-sm">Mercredi 22 Janvier • 18h30</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </div>
                    </div>
                </div>
                
                <div id="presenceFormDetails" class="hidden mt-6 p-4 bg-gray-50 rounded-lg">
                    <h4 class="font-bold text-gray-800 mb-4" id="programmeTitleDetails"></h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                            <div class="flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="presenceDetails" value="present" class="h-5 w-5 text-green-600" checked>
                                    <span class="ml-2 text-gray-700">Présent</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="presenceDetails" value="absent" class="h-5 w-5 text-red-600">
                                    <span class="ml-2 text-gray-700">Absent</span>
                                </label>
                            </div>
                        </div>
                        
                        <div id="motifContainerDetails" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Motif d'absence</label>
                            <textarea id="motifDetails" rows="3" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Raison de l'absence..."></textarea>
                        </div>
                        
                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" onclick="closePresenceModal()" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                                Annuler
                            </button>
                            <button type="button" onclick="enregistrerPresenceDetails()" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                <i class="fas fa-save mr-2"></i> Enregistrer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Gestion des tabs
        function showTab(tabName) {
            // Masquer tous les contenus
            document.getElementById('content-infos').classList.add('hidden');
            document.getElementById('content-historique').classList.add('hidden');
            
            // Désactiver tous les tabs
            document.getElementById('tab-infos').classList.remove('tab-active', 'text-blue-700');
            document.getElementById('tab-infos').classList.add('text-gray-500');
            document.getElementById('tab-historique').classList.remove('tab-active', 'text-blue-700');
            document.getElementById('tab-historique').classList.add('text-gray-500');
            
            // Afficher le contenu sélectionné
            document.getElementById(`content-${tabName}`).classList.remove('hidden');
            
            // Activer le tab sélectionné
            document.getElementById(`tab-${tabName}`).classList.add('tab-active', 'text-blue-700');
            document.getElementById(`tab-${tabName}`).classList.remove('text-gray-500');
        }
        
        // Modal présence
        function showPresenceModal() {
            document.getElementById('presenceModal').classList.remove('hidden');
        }
        
        function closePresenceModal() {
            document.getElementById('presenceModal').classList.add('hidden');
            document.getElementById('presenceFormDetails').classList.add('hidden');
            document.getElementById('motifDetails').value = '';
            document.querySelector('input[name="presenceDetails"][value="present"]').checked = true;
            document.getElementById('motifContainerDetails').classList.add('hidden');
        }
        
        function selectProgrammeForDetails(programmeId) {
            const programmeTitle = document.querySelector(`[onclick="selectProgrammeForDetails(${programmeId})"] h4`).textContent;
            document.getElementById('programmeTitleDetails').textContent = programmeTitle;
            document.getElementById('presenceFormDetails').classList.remove('hidden');
        }
        
        // Afficher/masquer motif d'absence
        document.querySelectorAll('input[name="presenceDetails"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.getElementById('motifContainerDetails').classList.toggle('hidden', this.value !== 'absent');
            });
        });
        
        function enregistrerPresenceDetails() {
            const presence = document.querySelector('input[name="presenceDetails"]:checked').value;
            const motif = document.getElementById('motifDetails').value;
            
            // Simulation
            alert(`Présence enregistrée pour {{ $nouveau->full_name }}\nStatut: ${presence}\nMotif: ${motif || 'Aucun'}`);
            
            closePresenceModal();
        }
    </script>
</body>
</html>