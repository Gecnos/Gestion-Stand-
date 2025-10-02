@extends('layouts.new')

@section('title', 'Mes Produits')

@section('content')
    <div class="container mx-auto px-4 py-10 max-w-7xl">

        <h1 class="text-2xl font-bold mb-6">Mes Produits pour le stand : {{ $stand->nom_stand }}</h1>

        @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6">
            <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Ajouter un nouveau produit
            </a>
        </div>

        @if ($products->isEmpty())
            <p class="text-gray-600">Vous n'avez pas encore ajouté de produits à votre stand.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img class="h-48 w-full object-cover" src="{{ $product->image_url ? asset('storage/' . $product->image_url) : 'https://placehold.co/600x400/3e4554/FFF?text=Produit' }}" alt="{{ $product->nom }}">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $product->nom }}</h3>
                            <p class="text-gray-600 text-sm mt-1 line-clamp-2">{{ $product->description }}</p>
                            <p class="text-xl font-bold text-gray-800 mt-3">{{ number_format($product->prix, 2, ',', ' ') }} CFA</p>
                            <div class="mt-4 flex justify-between items-center">
                                <a href="{{ route('entrepreneur.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">Modifier</a>
                                <form action="{{ route('entrepreneur.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection