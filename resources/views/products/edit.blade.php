@extends('layouts.new')

@section('title', 'Modifier le Produit')

@section('content')
    <div class="bg-gray-100 min-h-screen py-10">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg p-8 md:p-10 border border-gray-200">

                <h1 class="text-3xl font-bold text-gray-900 mb-8">Modifier le produit : {{ $product->nom }}</h1>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('entrepreneur.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- 1. Nom du produit --}}
                    <div class="mb-6">
                        <label for="nom" class="block text-lg font-medium text-gray-700 mb-2">Nom du produit</label>
                        <input type="text" id="nom" name="nom" value="{{ old('nom', $product->nom) }}"
                            placeholder="Ex: Coq au vin traditionnel"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm 
                                      focus:ring-indigo-500 focus:border-indigo-500 transition duration-150"
                            required>
                        @error('nom')
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
                            required>{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 3. Prix (CFA) --}}
                    <div class="mb-6">
                        <label for="prix" class="block text-lg font-medium text-gray-700 mb-2">Prix (CFA)</label>
                        <input type="number" id="prix" name="prix" value="{{ old('prix', $product->prix) }}" min="0"
                            step="0.01"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm 
                                      focus:ring-indigo-500 focus:border-indigo-500 transition duration-150"
                            required>
                        @error('prix')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 4. Image actuelle et nouvelle image --}}
                    <div class="mb-6">
                        <label for="image" class="block text-lg font-medium text-gray-700 mb-2">Image du produit</label>
                        @if ($product->image_url)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Image actuelle :</p>
                                <img src="{{ asset('storage/' . $product->image_url) }}" alt="Image actuelle" class="w-32 h-32 object-cover rounded-lg">
                            </div>
                        @endif
                        <input type="file" name="image" id="image"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                              file:rounded-lg file:border-0
                              file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700
                              hover:file:bg-blue-100">
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Boutons d'Action --}}
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('entrepreneur.products.index') }}"
                            class="px-6 py-3 border border-gray-300 rounded-lg text-base font-medium text-gray-700 
                                  bg-white hover:bg-gray-50 transition duration-150 ease-in-out shadow-sm">
                            Annuler
                        </a>
                        <button type="submit"
                            class="px-6 py-3 border border-transparent rounded-lg text-base font-medium text-white 
                                       bg-gray-900 hover:bg-gray-700 transition duration-150 ease-in-out shadow-md">
                            Mettre à jour le produit
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
