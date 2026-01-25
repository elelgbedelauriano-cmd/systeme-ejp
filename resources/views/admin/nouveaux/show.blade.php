@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Détails du Nouveau</h2>
            <a href="{{ route('admin.nouveaux.index') }}" 
               class="text-blue-600 hover:text-blue-900">
                ← Retour
            </a>
        </div>
        
        <div class="space-y-4">
            <p><strong>Nom :</strong> {{ $nouveau->prenom }} {{ $nouveau->nom }}</p>
            <p><strong>Email :</strong> {{ $nouveau->email }}</p>
            <p><strong>Profession :</strong> {{ $nouveau->profession }}</p>
            <p><strong>FIJ :</strong> {{ $nouveau->fij }}</p>
            <p><strong>Date d'enregistrement :</strong> 
               {{ \Carbon\Carbon::parse($nouveau->date_enregistrement)->format('d/m/Y') }}
            </p>
            @if($nouveau->aide)
                <p><strong>Assigné à :</strong> {{ $nouveau->aide->name }}</p>
            @endif
        </div>
    </div>
</div>
@endsection