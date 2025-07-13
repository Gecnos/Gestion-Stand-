@extends('layouts.app')

@section('content')
<!-- HERO SECTION -->
<section class="relative h-[70vh] flex items-center justify-center text-center text-white overflow-hidden">
    <img src="https://images.unsplash.com/photo-1555992336-03a23a8c5f96?auto=format&fit=crop&w=1400&q=80" alt="Eat&Drink background" class="absolute inset-0 w-full h-full object-cover opacity-50"/>
    <div class="relative z-10 max-w-3xl px-6">
        <h1 class="text-4xl md:text-6xl font-extrabold drop-shadow-lg mb-4">Eat&Drink Cotonou</h1>
        <p class="text-lg md:text-2xl mb-8 leading-relaxed drop-shadow">
            🇧🇯 6ᵉ édition • 1 → 6 avril 2025 · Street‑food, cocktails, live music & cooking shows
        </p>
       @guest
    <a href="/demande-stand" class="inline-block bg-indigo-600 hover:bg-indigo-700 px-8 py-3 rounded-lg text-lg font-semibold transition">
        Demander mon stand
    </a>
@else
    <a href="/redirect-by-role" class="inline-block bg-green-600 hover:bg-green-700 px-8 py-3 rounded-lg text-lg font-semibold transition">
        Accéder à mon espace
    </a>
@endguest

    </div>
</section>

<!-- CONCEPT SECTION -->
<section class="py-16 bg-gray-50">
    <div class="max-w-5xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
        <img src="https://images.unsplash.com/photo-1498654896293-37aacf113fd9?auto=format&fit=crop&w=700&q=80" alt="Food stand" class="rounded-2xl shadow-lg"/>
        <div>
            <h2 class="text-3xl font-bold mb-4 text-gray-800">Un festival pour les gourmands et les créateurs</h2>
            <p class="text-gray-600 mb-4 leading-relaxed">
                Inspiré par la communauté <strong>@eatdrinkcotonou</strong> sur Instagram, Eat&Drink célèbre la scène food béninoise :
            </p>
            <ul class="space-y-2 text-gray-700">
                <li>🍤 <strong>70+ stands</strong> de street‑food, artisans & chefs</li>
                <li>🎧 <strong>Concerts live</strong> et DJ‑sets chaque soir</li>
                <li>🍹 <strong>Ateliers cocktails</strong> & masterclasses culinaires</li>
                <li>🏆 <strong>Concours “Meilleur Stand”</strong> avec votes du public</li>
            </ul>
        </div>
    </div>
</section>
@endsection
