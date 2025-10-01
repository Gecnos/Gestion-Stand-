@extends('layouts.new')


@section('title', 'Dashboard Entrepreneur')

@section('content')
    {{-- Utilisation des variables réelles transmises par le contrôleur --}}

    <div class="bg-gray-50 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Titre et statut --}}
            <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Dashboard Entrepreneur</h1>
            <p class="text-xl text-gray-700 mb-6">Bienvenue, {{ $standName }}</p>

            {{-- Message d'approbation --}}
            {{-- @if($isApproved)
                <div class="mb-8">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold 
                                 bg-green-100 text-green-800 border border-green-300 shadow-sm">
                        Compte Approuvé
                    </span>
                    <span class="ml-3 text-sm text-gray-600">
                        Votre stand est maintenant visible publiquement.
                    </span>
                </div>
            @else
                 <div class="mb-8">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold 
                                 bg-yellow-100 text-yellow-800 border border-yellow-300 shadow-sm">
                        En Attente d'Approbation
                    </span>
                    <span class="ml-3 text-sm text-gray-600">
                        Votre stand est en cours de validation et n'est pas encore public.
                    </span>
                </div>
            @endif --}}

            {{-- Cartes de Statistiques (K.P.I.) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                
                {{-- 1. Produits --}}
                <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100 flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <h2 class="text-xl font-semibold text-gray-600">Produits</h2>
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10m0-10l-8-4-8 4"></path></svg>
                    </div>
                    <div class="mt-4">
                        <p class="text-4xl font-bold text-gray-900">{{ $productsCount }}</p>
                        <p class="text-sm text-gray-500">dans votre catalogue</p>
                    </div>
                </div>

                {{-- 2. Commandes --}}
                <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100 flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <h2 class="text-xl font-semibold text-gray-600">Commandes</h2>
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M10 15h.01"></path></svg>
                    </div>
                    <div class="mt-4">
                        <p class="text-4xl font-bold text-gray-900">{{ $ordersCount }}</p>
                        <p class="text-sm text-gray-500">commandes reçues</p>
                    </div>
                </div>

                {{-- 3. Chiffre d'affaires --}}
                <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100 flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <h2 class="text-xl font-semibold text-gray-600">Chiffre d'affaires</h2>
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <div class="mt-4">
                        <p class="text-4xl font-bold text-gray-900">{{ number_format($revenue, 2, ',', ' ') }} CFA</p>
                        <p class="text-sm text-gray-500">total des ventes</p>
                    </div>
                </div>
                
                {{-- 4. Visibilité --}}
                <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100 flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <h2 class="text-xl font-semibold text-gray-600">Visibilité</h2>
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </div>
                    <div class="mt-4">
                        <p class="text-4xl font-bold text-gray-900">{{ $visibility }}</p>
                        <p class="text-sm text-gray-500">stand visible</p>
                    </div>
                </div>
            </div>

            {{-- Sections d'Actions (Gestion des Produits & Commandes) --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Gestion des Produits --}}
                <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Gestion des Produits</h2>
                    <p class="text-gray-600 mb-6">Ajoutez, modifiez ou supprimez vos produits du catalogue.</p>
                    <div class="flex space-x-4">
                        <a href="{{ route('products.index', $stand->id) }}"
                           class="inline-flex items-center px-5 py-3 border border-transparent text-base font-medium rounded-lg 
                                  shadow-sm text-white bg-gray-900 hover:bg-gray-700 transition duration-150 ease-in-out">
                            Gérer mes produits
                        </a>
                        <a href="{{ route('products.create', $stand->id) }}"
                           class="inline-flex items-center px-5 py-3 border border-gray-300 text-base font-medium rounded-lg 
                                  shadow-sm text-gray-700 bg-white hover:bg-gray-50 transition duration-150 ease-in-out">
                            Ajouter un produit
                        </a>
                    </div>
                </div>

                {{-- Mes Commandes --}}
                <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Mes Commandes</h2>
                    <p class="text-gray-600 mb-6">Consultez et gérez les commandes reçues de vos clients.</p>
                    <div class="flex space-x-4">
                        <a href="{{ route('orders.index', $stand->id) }}"
                           class="inline-flex items-center px-5 py-3 border border-transparent text-base font-medium rounded-lg 
                                  shadow-sm text-white bg-gray-900 hover:bg-gray-700 transition duration-150 ease-in-out">
                            Voir les commandes
                        </a>
                        <a href="{{ route('stands.show', $stand->id) }}"
                           class="inline-flex items-center px-5 py-3 border border-gray-300 text-base font-medium rounded-lg 
                                  shadow-sm text-gray-700 bg-white hover:bg-gray-50 transition duration-150 ease-in-out">
                            Voir mon stand
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
