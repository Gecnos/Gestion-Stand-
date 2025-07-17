@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-7xl">

    <h1 class="text-2xl font-bold mb-6">Tableau de bord Administrateur</h1>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white shadow rounded-lg p-5">
            <div class="text-sm text-gray-500">Demandes en attente</div>
            <div class="text-3xl font-bold text-gray-900 mt-1">{{ $nbDemandes }}</div>
            <div class="text-sm text-gray-400">à traiter</div>
        </div>

        <div class="bg-white shadow rounded-lg p-5">
            <div class="text-sm text-gray-500">Exposants approuvés</div>
            <div class="text-3xl font-bold text-gray-900 mt-1">{{ $nbExposants }}</div>
            <div class="text-sm text-gray-400">stands actifs</div>
        </div>

        <div class="bg-white shadow rounded-lg p-5">
            <div class="text-sm text-gray-500">Commandes totales</div>
            <div class="text-3xl font-bold text-gray-900 mt-1">{{ $nbCommandes }}</div>
            <div class="text-sm text-gray-400">sur la plateforme</div>
        </div>

        <div class="bg-white shadow rounded-lg p-5">
            <div class="text-sm text-gray-500">Chiffre d'affaires</div>
            <div class="text-3xl font-bold text-gray-900 mt-1">
                {{ number_format($chiffreAffaires, 2, ',', ' ') }} FCFA
            </div>
            <div class="text-sm text-gray-400">volume total</div>
        </div>
    </div>

    {{-- Liste des demandes --}}
    <h2 class="text-xl font-semibold mb-4">Demandes de stands en attente</h2>

    @if($demandes->isEmpty())
        <p class="text-gray-600">Aucune demande en attente pour le moment.</p>
    @else
        <div class="overflow-x-auto rounded shadow bg-white">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Nom</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Email</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Inscrit le</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($demandes as $demande)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $demande->name }}</td>
                            <td class="px-4 py-2">{{ $demande->email }}</td>
                            <td class="px-4 py-2">{{ $demande->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                {{-- Approuver --}}
                                <form action="{{ url('/admin/approve/'.$demande->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded bg-green-600 text-white text-sm hover:bg-green-700 transition">
                                        Approuver
                                    </button>
                                </form>

                                {{-- Rejeter avec motif --}}
                                <form action="{{ url('/admin/reject/'.$demande->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <input type="text" name="motif" placeholder="Motif du rejet" required
                                           class="px-2 py-1 text-sm border border-gray-300 rounded">
                                    <button type="submit" class="px-3 py-1 rounded bg-red-600 text-white text-sm hover:bg-red-700 transition">
                                        Rejeter
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
