@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-4xl">
    <h1 class="text-2xl font-bold mb-6">Bienvenue, {{ Auth::user()->name }}</h1>

    {{-- Quick stats or shortcuts --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ url('/entrepreneur/stand/create') }}" class="p-6 rounded-lg shadow bg-white hover:bg-gray-50 transition flex items-center space-x-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-green-600">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Créer ou modifier mon stand</span>
        </a>

        <a href="{{ url('/entrepreneur/products') }}" class="p-6 rounded-lg shadow bg-white hover:bg-gray-50 transition flex items-center space-x-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-indigo-600">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9" />
            </svg>
            <span>Gérer mes produits</span>
        </a>
    </div>
</div>
@endsection