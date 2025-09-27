@extends('layouts.app')

@section('content')

    {{-- Bannière de l'Exposant (Hero Section) --}}
    <div class="relative w-full h-80 bg-gray-900 overflow-hidden shadow-xl">
        {{-- Image de fond du stand --}}
        <img class="w-full h-full object-cover opacity-60" 
             src="{{ $stand->image_url ?? 'https://placehold.co/1200x320/2F3647/FFFFFF?text=Stand+Detail' }}" 
             alt="Bannière du stand {{ $stand->nom_stand }}">

        {{-- Overlay de Contenu --}}
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent flex items-end">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8 text-white w-full">
                
                <div class="flex items-center space-x-4 mb-2">
                    {{-- Tag 'Exposant Certifié' --}}
                    @if ($stand->is_certified)
                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold text-white bg-green-500 rounded-full shadow-lg">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            Exposant Certifié
                        </span>
                    @endif
                    
                    {{-- Numéro de Stand --}}
                    <span class="inline-flex items-center text-xs font-medium text-gray-300">
                        <svg class="w-4 h-4 mr-1 text-red-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                        Stand #{{ $stand->id }}
                    </span>
                </div>

                {{-- Titre et Description du Stand --}}
                <h1 class="text-5xl font-extrabold tracking-tight mb-2">
                    {{ $stand->nom_stand }}
                </h1>
                <p class="text-lg font-medium text-gray-300">
                    {{ $stand->description }}
                </p>
            </div>
        </div>
    </div>

    {{-- Section des Produits --}}
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <h2 class="text-3xl font-bold text-gray-900 mb-8 px-4 sm:px-0">Nos Produits</h2>

            @if ($stand->produits && $stand->produits->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    {{-- Boucle sur les produits de l'exposant --}}
                    @foreach ($stand->produits as $produit)

                        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden flex flex-col">
                            
                            {{-- Image du produit (simulée ici sans véritable image pour la carte produit) --}}
                            <div class="h-48 bg-gray-100 flex items-center justify-center">
                                <span class="text-gray-400 text-sm">Image de {{ $produit->name }}</span>
                            </div>

                            <div class="p-6 flex flex-col justify-between flex-grow">
                                <div>
                                    {{-- Nom du produit --}}
                                    <h3 class="text-xl font-semibold text-gray-800 mb-1">
                                        {{ $produit->name }}
                                    </h3>
                                    
                                    {{-- Prix du produit --}}
                                    <p class="text-2xl font-bold text-gray-900 mb-2">
                                        {{ number_format($produit->price, 2, ',', ' ') }} CFA
                                    </p>

                                    {{-- Description du produit --}}
                                    <p class="text-gray-500 text-sm mb-4 line-clamp-2 h-10">
                                        {{ $produit->description ?? 'Pas de description.' }}
                                    </p>
                                </div>

                                {{-- Bloc d'ajout au panier --}}
                                <form action="#" method="POST" class="mt-4">
                                    @csrf {{-- Anti-CSRF token pour Laravel --}}
                                    
                                    <input type="hidden" name="produit_id" value="{{ $produit->id }}">

                                    <div class="flex items-center justify-between space-x-4">
                                        
                                        {{-- Contrôles de quantité (très simplifiés) --}}
                                        <div class="flex items-center border border-gray-300 rounded-lg p-1 text-gray-700">
                                            {{-- Boutons/Inputs de quantité devraient être gérés par JS, ici c'est statique pour le template --}}
                                            <button type="button" class="w-8 h-8 flex items-center justify-center text-lg hover:bg-gray-100 rounded-md font-medium" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                -
                                            </button>
                                            <input type="number" name="quantity" value="1" min="1" max="10" readonly
                                                   class="w-12 text-center text-sm border-0 focus:ring-0 bg-transparent p-0">
                                            <button type="button" class="w-8 h-8 flex items-center justify-center text-lg hover:bg-gray-100 rounded-md font-medium" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                +
                                            </button>
                                        </div>

                                        {{-- Bouton Ajouter au panier --}}
                                        <button type="submit"
                                                class="flex-1 flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg 
                                                       text-white bg-gray-900 hover:bg-gray-700 transition duration-150 shadow-md">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            Ajouter au panier
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 mt-8 text-lg">Cet exposant n'a pas encore de produits listés.</p>
            @endif

            {{-- Bouton de retour --}}
            <div class="mt-12 text-center">
                <a href="{{ route('stands.index') }}" class="text-gray-600 hover:text-gray-800 text-base font-medium transition duration-150 flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Retour à la liste des exposants
                </a>
            </div>

        </div>
    </div>
@endsection
