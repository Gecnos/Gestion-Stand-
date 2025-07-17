@extends('layouts.app') {{-- Si tu as un layout, sinon retire cette ligne --}}

@section('content')

<div class="bg-gray-100 text-gray-800">

    {{-- Section principale --}}
    <div class="text-center py-20 px-6 bg-white">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Eat&Drink 2024</h1>
        <p class="text-lg md:text-xl max-w-2xl mx-auto mb-6">
            Découvrez le plus grand événement culinaire de la région ! Rencontrez nos artisans passionnés, dégustez leurs créations uniques et commandez vos produits favoris en ligne.
        </p>
        <div class="flex justify-center gap-4 mt-4">
            <a href="#" class="bg-gray-900 text-white px-6 py-2 rounded hover:bg-gray-800">Découvrir les Exposants</a>
            <a href="/demande-stand" class="bg-white border border-gray-300 px-6 py-2 rounded hover:bg-gray-200">Devenir Exposant</a>
        </div>
    </div>

    {{-- Infos événement --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 px-6 py-10 text-center bg-gray-50">
        <div class="p-6 rounded shadow-sm bg-white">
            <div class="text-3xl mb-2">📅</div>
            <h3 class="font-semibold text-lg mb-1">Dates</h3>
            <p>15–17 Mars 2024<br>3 jours de festivités</p>
        </div>
        <div class="p-6 rounded shadow-sm bg-white">
            <div class="text-3xl mb-2">📍</div>
            <h3 class="font-semibold text-lg mb-1">Lieu</h3>
            <p>Palais des Congrès<br>Boulevard de la Marina, Cotonou</p>
        </div>
        <div class="p-6 rounded shadow-sm bg-white">
            <div class="text-3xl mb-2">🧑‍🍳</div>
            <h3 class="font-semibold text-lg mb-1">Exposants</h3>
            <p>50+ Entrepreneurs<br>Producteurs locaux</p>
        </div>
        <div class="p-6 rounded shadow-sm bg-white">
            <div class="text-3xl mb-2">🛒</div>
            <h3 class="font-semibold text-lg mb-1">Commandes</h3>
            <p>En ligne<br>Livraison possible</p>
        </div>
    </div>

    {{-- Pourquoi participer ? --}}
    <div class="py-14 bg-white px-6">
        <h2 class="text-2xl font-bold text-center mb-10">Pourquoi Participer ?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div>
                <div class="text-3xl mb-2">🤝</div>
                <h3 class="font-semibold text-lg mb-1">Rencontrez les Entreprenurs et restaurants</h3>
                <p>Échangez directement avec nos entrepreneurs passionnés et découvrez leur savoir-faire.</p>
            </div>
            <div>
                <div class="text-3xl mb-2">💻</div>
                <h3 class="font-semibold text-lg mb-1">Commandez en Ligne</h3>
                <p>Parcourez les stands virtuellement et commandez vos produits favoris depuis chez vous.</p>
            </div>
            <div>
                <div class="text-3xl mb-2">🎉</div>
                <h3 class="font-semibold text-lg mb-1">Événement Unique</h3>
                <p>Trois jours d’animations, dégustations et découvertes culinaires exceptionnelles.</p>
            </div>
        </div>
    </div>

    {{-- Appel à l'action final --}}
    <div class="bg-gray-900 text-white text-center py-16 px-6">
        <h2 class="text-2xl md:text-3xl font-bold mb-4">Rejoignez l'Aventure Eat&Drink</h2>
        <p class="mb-6 max-w-2xl mx-auto">Que vous soyez visiteur ou entrepreneur, il y a une place pour vous dans notre événement !</p>
        <div class="flex justify-center gap-4">
            <a href="#" class="bg-white text-gray-900 px-6 py-2 rounded hover:bg-gray-200">Explorer les Stands</a>
            <a href="/demande-stand" class="bg-gray-800 text-white px-6 py-2 rounded hover:bg-gray-700">Candidater comme Exposant</a>
        </div>
    </div>

</div>
@endsection
