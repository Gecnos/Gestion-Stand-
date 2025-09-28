@extends('layouts.app')

@section('content')
    
    @php
        // Récupérer le panier actuel pour ce stand (par stand_id)
        $cart = session('cart', []);
        $standCart = $cart[$stand->id]['items'] ?? [];
        $totalCartPrice = 0;

        foreach ($standCart as $item) {

            $itemPrice = $item['prix'] ?? $item['price'] ?? 0;
            $itemQuantity = $item['quantity'] ?? 0;

            $totalCartPrice += $itemPrice * $itemQuantity;
        }
    @endphp

    <div class="bg-gray-50 min-h-screen">
        
        {{-- Bannière du Stand --}}
        <div class="relative bg-gray-900 h-96 overflow-hidden">
            <img class="w-full h-full object-cover opacity-60" 
                 {{-- Utilisation d'une image téléchargée comme fallback --}}
                 src="{{ $stand->image_url ?? '__file_url__uploaded:image_480d8e.jpg-d1210ae2-3e1e-4411-845c-bedb13e86bbf' }}" 
                 alt="Image du stand {{ $stand->nom_stand }}">
            
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent"></div>
            
            <div class="absolute bottom-0 left-0 p-8 text-white max-w-7xl mx-auto w-full">
                <div class="flex items-center space-x-3 mb-2">
                    @if ($stand->is_certified)
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-500 text-white">
                            Exposant Certifié
                        </span>
                    @endif
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-700 text-white">
                        Stand #{{ $stand->id }}
                    </span>
                </div>
                <h1 class="text-5xl font-extrabold">{{ $stand->nom_stand }}</h1>
                <p class="text-xl text-gray-300">{{ $stand->description }}</p>
            </div>
        </div>

        {{-- Contenu Principal (Produits et Panier) --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            
            {{-- Messages de Session --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="flex flex-col lg:flex-row lg:space-x-8">

                {{-- Colonne des Produits (Gauche) --}}
                <div class="lg:w-3/4">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b pb-2">Nos Produits</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @forelse ($stand->produits as $produit)
                            {{-- Carte de Produit --}}
                            <div class="bg-white rounded-xl shadow-lg flex flex-col justify-between border border-gray-100 overflow-hidden">
                                
                                {{-- IMAGE DU PRODUIT AJOUTÉE ICI --}}
                                @php
                                    $productImageUrl = $produit->image_url ?? 'https://placehold.co/600x400/3e4554/FFF?text=Produit';
                                @endphp

                                <div class="h-48">
                                    <img src="{{ $productImageUrl }}" alt="Image de {{ $produit->name ?? $produit->nom }}" 
                                         class="w-full h-full object-cover">
                                </div>


                                <div class="p-6">
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                        
                                        {{-- Ajoutez les informations nécessaires pour la création du panier (nom, prix, etc.) --}}
                                        <input type="hidden" name="name" value="{{ $produit->name ?? $produit->nom }}">
                                        <input type="hidden" name="prix" value="{{ $produit->prix }}">
                                        
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-800 mb-1 line-clamp-1">{{ $produit->name ?? $produit->nom }}</h3> 
                                            {{-- Utilise $produit->prix pour l'affichage --}}
                                            <p class="text-2xl font-extrabold text-gray-900 mb-3">{{ number_format($produit->prix, 2, ',', ' ') }} CFA</p>
                                            <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ $produit->description }}</p>
                                        </div>

                                        {{-- Contrôle de Quantité et Ajout --}}
                                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                            <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                                <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"
                                                    class="bg-gray-100 hover:bg-gray-200 p-2 text-gray-600 font-bold transition duration-150">-</button>
                                                <input type="number" name="quantity" min="1" value="1" readonly
                                                    class="w-12 text-center border-none focus:ring-0 p-2 text-gray-800 bg-white">
                                                <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"
                                                    class="bg-gray-100 hover:bg-gray-200 p-2 text-gray-600 font-bold transition duration-150">+</button>
                                            </div>

                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg shadow-md 
                                                        text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                Ajouter au panier
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 col-span-full">Cet exposant n'a pas encore ajouté de produits.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Colonne du Panier (Droite) --}}
                <div class="lg:w-1/4 mt-10 lg:mt-0">
                    <div class="sticky top-4 bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-3">Votre Panier</h3>
                        
                        {{-- Liste des Produits dans le Panier --}}
                        @if (empty($standCart))
                            <p class="text-gray-500 italic">Le panier est vide pour ce stand.</p>
                        @else
                            <div class="space-y-4">
                                @foreach ($standCart as $id => $item)
                                    @php
                                        // On utilise le même prix robuste pour l'affichage que pour le calcul du total.
                                        $itemPrice = $item['prix'] ?? $item['price'] ?? 0;
                                    @endphp
                                    <div class="flex justify-between items-start text-sm">
                                        <p class="text-gray-700 font-medium">
                                            {{ $item['quantity'] }} x {{ $item['name'] }} 
                                            {{-- Utilise $itemPrice --}}
                                            <span class="text-gray-500">({{ number_format($itemPrice, 2, ',', ' ') }} CFA)</span>
                                        </p>
                                        {{-- Utilise $itemPrice pour le calcul du sous-total --}}
                                        <p class="text-gray-900 font-semibold">{{ number_format($itemPrice * $item['quantity'], 2, ',', ' ') }} CFA</p>
                                    </div>
                                @endforeach
                            </div>
                            
                            {{-- Total --}}
                            <div class="pt-4 mt-6 border-t border-gray-200">
                                <div class="flex justify-between font-bold text-lg text-green-600">
                                    <span>Total de la commande</span>
                                    <span>{{ number_format($totalCartPrice, 2, ',', ' ') }} CFA</span>
                                </div>
                            </div>

                            {{-- Formulaire de Finalisation de Commande  --}}
                            <form action="{{ route('order.store') }}" method="POST" class="mt-6 space-y-4">
                                @csrf
                                <input type="hidden" name="stand_id" value="{{ $stand->id }}">
                                
                                

                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm 
                                            text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                                    Confirmer et Payer ({{ number_format($totalCartPrice, 2, ',', ' ') }} CFA)
                                </button>
                            </form>
                            
                            {{-- Bouton pour vider le panier --}}
                            <form action="{{ route('cart.clear', ['stand_id' => $stand->id]) }}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg 
                                            text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 transition duration-150 ease-in-out">
                                    Vider le Panier
                                </button>
                            </form>

                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
                {{-- Bouton de retour --}}
            <div class="mt-12 text-center">
                <a href="{{ route('stands.index') }}" class="text-gray-600 hover:text-gray-800 text-base font-medium transition duration-150 flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Retour à la liste des exposants
                </a>
            </div>

@endsection
