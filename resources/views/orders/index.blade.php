@extends('layouts.new')

@section('title', 'Mes Commandes')

@section('content')
    <div class="container mx-auto px-4 py-10 max-w-7xl">

        <h1 class="text-2xl font-bold mb-6">Commandes pour le stand : {{ $stand->nom_stand }}</h1>

        @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($orders->isEmpty())
            <p class="text-gray-600">Aucune commande n'a été passée pour votre stand pour le moment.</p>
        @else
            <div class="overflow-x-auto rounded shadow bg-white">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">ID Commande</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Client</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Total</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Statut</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Date</th>
                            {{-- <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 font-mono text-sm">#{{ $order->id }}</td>
                                <td class="px-4 py-2">{{ $order->user->name ?? 'Client non connecté' }}</td>
                                <td class="px-4 py-2 font-semibold">{{ number_format($order->total, 2, ',', ' ') }} FCFA</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @switch($order->statut)
                                            @case('en_attente_paiement') bg-yellow-100 text-yellow-800 @break
                                            @case('payee') bg-green-100 text-green-800 @break
                                            @case('annulee') bg-red-100 text-red-800 @break
                                            @default bg-gray-100 text-gray-800
                                        @endswitch">
                                        {{ str_replace('_', ' ', $order->statut) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                {{-- <td class="px-4 py-2">
                                    <a href="#" class="text-blue-600 hover:underline">Voir détails</a>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
