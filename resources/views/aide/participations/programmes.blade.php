<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programmes - Aide EJP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="md:flex">
        <!-- Sidebar (identique aux autres pages) -->
        <div class="bg-blue-800 text-white md:w-64">
            <div class="p-4">
                <h1 class="text-xl font-bold">
                    <i class="fas fa-hands-helping mr-2"></i>Aide EJP
                </h1>
                <p class="text-blue-200 text-sm">Bienvenue, {{ Auth::user()->name }}</p>
            </div>
            
            <nav class="mt-4">
                <a href="{{ route('aide.dashboard') }}" 
                   class="block py-3 px-4 hover:bg-blue-700 {{ request()->routeIs('aide.dashboard') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-home mr-3"></i> Accueil
                </a>
                <a href="{{ route('aide.nouveaux.index') }}" 
                   class="block py-3 px-4 hover:bg-blue-700 {{ request()->routeIs('aide.nouveaux.*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-users mr-3"></i> Nouveaux
                </a>
                <a href="{{ route('aide.participations.programmes') }}" 
                   class="block py-3 px-4 hover:bg-blue-700 {{ request()->routeIs('aide.participations.*') ? 'bg-blue-700 border-r-4 border-yellow-400' : '' }}">
                    <i class="fas fa-calendar-check mr-3"></i> Présences
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
                    <i class="fas fa-calendar-check mr-2"></i>Programmes de la Semaine
                </h2>
                <p class="text-gray-600">Marquez les présences/absences de vos nouveaux</p>
            </div>
            
            <!-- Liste des programmes -->
            <div class="space-y-6">
                @foreach($programmes as $programme)
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800">{{ $programme->titre }}</h3>
                            <div class="flex items-center text-gray-600 mt-2">
                                <i class="fas fa-calendar-day mr-2"></i>
                                <span>{{ isset($programme->date_programme) ? $programme->date_programme->format('d/m/Y H:i') : 'Date non définie' }}</span>
                            </div>
                        </div>
                        
                        <a href="#" 
                           onclick="ouvrirModalMarquerPresence({{ $programme->id }})"
                           class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                            <i class="fas fa-users mr-2"></i> Marquer les présences
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Message si aucun programme -->
            @if(empty($programmes))
            <div class="text-center py-12 bg-white rounded-xl shadow">
                <i class="fas fa-calendar-times text-gray-300 text-5xl mb-4"></i>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Aucun programme cette semaine</h3>
                <p class="text-gray-500">Les programmes apparaîtront ici une fois créés par l'administration</p>
            </div>
            @endif
        </main>
    </div>
    
    <!-- Modal pour marquer les présences -->
    <div id="modalMarquerPresence" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800" id="modalTitreProgramme">Programme</h3>
                    <button onclick="fermerModalMarquerPresence()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
                
                <div id="modalContenuNouveaux">
                    <!-- Liste des nouveaux à charger dynamiquement -->
                    <p class="text-gray-500">Chargement des nouveaux...</p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Fonction pour ouvrir le modal
        function ouvrirModalMarquerPresence(programmeId) {
            // Met à jour le titre
            document.getElementById('modalTitreProgramme').textContent = 'Programme #' + programmeId;
            
            // Charge la liste des nouveaux depuis l'API
            chargerNouveauxPourProgramme(programmeId);
            
            // Affiche le modal
            document.getElementById('modalMarquerPresence').classList.remove('hidden');
        }
        
        function fermerModalMarquerPresence() {
            document.getElementById('modalMarquerPresence').classList.add('hidden');
        }
        
        // Fonction pour charger les nouveaux
        function chargerNouveauxPourProgramme(programmeId) {
            // Envoie une requête AJAX pour récupérer les nouveaux
            fetch(`/api/aide/nouveaux`)
                .then(response => response.json())
                .then(nouveaux => {
                    let html = '<div class="space-y-4">';
                    
                    nouveaux.forEach(nouveau => {
                        html += `
                            <div class="border rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="font-bold text-blue-700">${nouveau.prenom.charAt(0)}${nouveau.nom.charAt(0)}</span>
                                        </div>
                                        <div>
                                            <div class="font-bold">${nouveau.prenom} ${nouveau.nom}</div>
                                            <div class="text-sm text-gray-600">${nouveau.profession}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex space-x-2">
                                        <button onclick="marquerPresence(${nouveau.id}, ${programmeId}, true)"
                                                class="px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200">
                                            <i class="fas fa-check mr-1"></i> Présent
                                        </button>
                                        <button onclick="marquerAbsence(${nouveau.id}, ${programmeId})"
                                                class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200">
                                            <i class="fas fa-times mr-1"></i> Absent
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Champ motif (caché par défaut) -->
                                <div id="motif-container-${nouveau.id}" class="mt-3 hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Motif d'absence</label>
                                    <textarea id="motif-${nouveau.id}" rows="2" class="w-full border-gray-300 rounded-lg" placeholder="Raison de l'absence..."></textarea>
                                    <button onclick="enregistrerAbsence(${nouveau.id}, ${programmeId})"
                                            class="mt-2 px-4 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                        Enregistrer
                                    </button>
                                </div>
                            </div>
                        `;
                    });
                    
                    html += '</div>';
                    document.getElementById('modalContenuNouveaux').innerHTML = html;
                })
                .catch(error => {
                    document.getElementById('modalContenuNouveaux').innerHTML = 
                        '<p class="text-red-500">Erreur de chargement des nouveaux</p>';
                });
        }
        
        // Fonctions pour marquer présence/absence
        function marquerPresence(nouveauId, programmeId) {
            alert(`Nouveau ${nouveauId} marqué présent pour programme ${programmeId}`);
            // Ici, tu ferais un appel API pour enregistrer
        }
        
        function marquerAbsence(nouveauId, programmeId) {
            // Affiche le champ motif
            document.getElementById(`motif-container-${nouveauId}`).classList.remove('hidden');
        }
        
        function enregistrerAbsence(nouveauId, programmeId) {
            const motif = document.getElementById(`motif-${nouveauId}`).value;
            alert(`Nouveau ${nouveauId} marqué absent. Motif: ${motif}`);
            // Ici, tu ferais un appel API pour enregistrer
        }
    </script>
</body>
</html>