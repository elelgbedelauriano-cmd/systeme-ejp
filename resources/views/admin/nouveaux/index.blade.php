@extends('layouts.admin')

@section('title', 'Gestion des Nouveaux')
@section('subtitle', 'Liste globale de tous les nouveaux inscrits')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tous les Nouveaux</h1>
            <p class="text-gray-600">Gestion globale des nouveaux inscrits</p>
        </div>
        <a href="{{ route('admin.nouveaux.create') }}" 
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            <i class="fas fa-user-plus mr-2"></i> Ajouter un nouveau
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($nouveaux->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Profession</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aide assigné</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($nouveaux as $nouveau)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="font-medium">{{ $nouveau->prenom }} {{ $nouveau->nom }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-600">{{ $nouveau->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div>{{ $nouveau->profession }}</div>
                            <div class="text-sm text-gray-500">{{ $nouveau->fij }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($nouveau->aide)
                                <div class="text-green-600">{{ $nouveau->aide->name }}</div>
                            @else
                                <span class="text-yellow-600">Non assigné</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($nouveau->date_enregistrement)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.nouveaux.show', $nouveau) }}" 
                               class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="#" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="px-6 py-4 border-t">
                {{ $nouveaux->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500">Aucun nouveau inscrit</p>
                <a href="{{ route('admin.nouveaux.create') }}" 
                   class="mt-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Ajouter le premier nouveau
                </a>
            </div>
        @endif
    </div>
</div>
@endsection