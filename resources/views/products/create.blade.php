@extends('layouts.new')

@section('title', 'Ajouter un Produit')

@section('content')
    {{-- On suppose que $standId est passé à la vue, car un produit est toujours lié à un stand --}}
    @php
        $standId = $standId ; // Fallback pour la démo, à remplacer par la vraie variable
    @endphp

    <div class="bg-gray-100 min-h-screen py-10">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg p-8 md:p-10 border border-gray-200">

                <h1 class="text-3xl font-bold text-gray-900 mb-8">Ajouter un produit</h1>

                {{-- Formulaire d'ajout de produit --}}
                <form action="{{ route('products.store', $standId) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Champ caché pour le Stand ID --}}
                    <input type="hidden" name="stand_id" value="{{ $standId }}">

                    {{-- 1. Nom du produit --}}
                    <div class="mb-6">
                        <label for="name" class="block text-lg font-medium text-gray-700 mb-2">Nom du produit</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            placeholder="Ex: Coq au vin traditionnel"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm 
                                      focus:ring-indigo-500 focus:border-indigo-500 transition duration-150"
                            required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 2. Description --}}
                    <div class="mb-6">
                        <label for="description" class="block text-lg font-medium text-gray-700 mb-2">Description</label>
                        <textarea id="description" name="description" rows="4"
                            placeholder="Décrivez votre produit, ses ingrédients, sa préparation..."
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm 
                                         focus:ring-indigo-500 focus:border-indigo-500 transition duration-150"
                            required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 3. Prix (CFA) --}}
                    <div class="mb-6">
                        <label for="price" class="block text-lg font-medium text-gray-700 mb-2">Prix (CFA)</label>
                        <input type="number" id="price" name="price" value="{{ old('price', 0) }}" min="0"
                            step="0.01"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm 
                                      focus:ring-indigo-500 focus:border-indigo-500 transition duration-150"
                            required>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 4. URL de l'image (optionnel) / OU Upload de Fichier --}}
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image du produit</label>
                        <input type="file" name="image" id="image"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                              file:rounded-lg file:border-0
                              file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700
                              hover:file:bg-blue-100">
                    </div>

                    {{-- Boutons d'Action --}}
                    <div class="flex justify-end space-x-4">
                        {{-- Annuler (retourne au dashboard) --}}
                        <a href="{{ route('entrepreneur.dashboard') }}"
                            class="px-6 py-3 border border-gray-300 rounded-lg text-base font-medium text-gray-700 
                                  bg-white hover:bg-gray-50 transition duration-150 ease-in-out shadow-sm">
                            Annuler
                        </a>

                        {{-- Ajouter --}}
                        <button type="submit"
                            class="px-6 py-3 border border-transparent rounded-lg text-base font-medium text-white 
                                       bg-gray-900 hover:bg-gray-700 transition duration-150 ease-in-out shadow-md">
                            Ajouter
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
