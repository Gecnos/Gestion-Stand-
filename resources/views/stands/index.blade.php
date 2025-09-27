@extends('layouts.app')

@section('content')

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- En-tête de la page -->
            <header class="text-center mb-12 px-4">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Nos Exposants</h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Découvrez les artisans passionnés qui participent à l'événement Eat&Drink. Chaque exposant vous propose des produits uniques et de qualité.
                </p>
            </header>

            <!-- Grille des Exposants -->
            <div class="flex flex-wrap -m-4 justify-center">

                @foreach ($stands as $stand)

                    {{-- CARD DE L'EXPOSANT --}}
                    <div class="flex flex-col w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-4">
                        <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl overflow-hidden 
                                     transform transition duration-500 hover:scale-[1.02] border border-gray-100 h-full">

                            {{-- Conteneur de l'Image et du Label --}}
                            <div class="relative h-48">
                                {{-- Si image_url est vide, utilisez un placeholder --}}
                                <img class="w-full h-full object-cover" 
                                     src="{{ $stand->image_url ?? 'https://placehold.co/600x400/2F3647/FFFFFF?text=Stand+Image' }}" 
                                     alt="Image du stand de {{ $stand->nom_stand }}">
                                
                                {{-- Tag Certifié --}}
                                @if ($stand->is_certified)
                                    <span class="absolute top-3 left-3 px-3 py-1 text-xs font-bold uppercase tracking-wider text-white bg-green-600 rounded-full shadow-md">
                                        Certifié
                                    </span>
                                @endif
                            </div>

                            {{-- Corps de la carte --}}
                            <div class="p-6 flex flex-col justify-between flex-grow">
                                <div>
                                    {{-- Nom de l'exposant (Utilise nom_stand) --}}
                                    <h3 class="text-xl font-bold text-gray-800 mb-1 line-clamp-1">
                                        {{ $stand->nom_stand }}
                                    </h3>

                                    {{-- Localisation/Stand ID --}}
                                    <p class="text-sm text-gray-500 mb-4 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-red-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                                        Stand #{{ $stand->id }}
                                    </p>

                                    {{-- Description --}}
                                    <p class="text-gray-600 mb-4 text-sm line-clamp-3 h-16">
                                        {{ $stand->description ?? 'Description non fournie.' }}
                                    </p>
                                </div>
                                
                                {{-- Pied de la carte (Tags et Bouton) --}}
                                <div class="flex justify-between items-end mt-4 pt-4 border-t border-gray-100">
                                    
                                    {{-- Tag 'Artisan local' si le champ est vrai --}}
                                    @if ($stand->is_local)
                                        <span class="text-xs font-semibold text-blue-700 px-3 py-1 bg-blue-100 rounded-full">
                                            Artisan local
                                        </span>
                                    @else
                                        <span></span>
                                    @endif
                                    
                                    {{-- Bouton "Voir le stand" --}}
                                    <a href="{{ route('stands.show', $stand->id) }}" 
                                       class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg 
                                              text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 
                                              transition duration-150 ease-in-out">
                                        Voir le stand
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>

            {{-- Message si aucun stand n'est trouvé --}}
            @if ($stands->isEmpty())
                <p class="text-center text-gray-500 mt-8 text-lg">Aucun exposant trouvé pour le moment.</p>
            @endif
        </div>
    </div>

@endsection
