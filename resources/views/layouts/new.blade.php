<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eat&Drink | @yield('title', 'Accueil')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Configuration de base de Tailwind pour la police Inter */
        html { font-family: 'Inter', sans-serif; }
    </style>

    <!-- Font Awesome pour les icônes (panier, utilisateur, déconnexion) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-50 antialiased">

    <!-- Barre de Navigation (Header) -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                
                {{-- Logo/Nom de l'Application --}}
                <div class="flex-shrink-0">
                    <a href="/" class="text-xl font-bold text-gray-800">Eat&Drink</a>               
                </div>

                {{-- Liens de Navigation --}}
                <div class="flex items-center space-x-4">
                    
                    {{-- Lien Nos Exposants (visible même pour les utilisateurs connectés)
                    <a href="{{ route('stands.index') }}" 
                       class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium transition duration-150">
                        Nos Exposants
                    </a> --}}

                    @auth
                        {{-- Menu Utilisateur Connecté (Basé sur image_ba9af0.png) --}}

                        {{-- Mon Dashboard --}}
                        <a href="{{ route('dashboard') }}" 
                           class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 
                                  px-4 py-2 text-sm font-semibold rounded-lg shadow-sm 
                                  transition duration-150 ease-in-out">
                            Mon Dashboard
                        </a>

                        {{-- Icône Panier (Lien vers le résumé global du panier si disponible) --}}
                        <a href="{{ route('entrepreneur.panier') }}" 
                           class="relative p-2 text-gray-600 hover:text-gray-900 rounded-full hover:bg-gray-100 transition duration-150">
                            <i class="fas fa-shopping-cart text-lg"></i>
                            @if(session('cart') && count(session('cart')) > 0)
                                <span class="absolute top-0 right-0 block h-2 w-2 rounded-full ring-2 ring-white bg-red-500"></span>
                            @endif
                        </a>

                        {{-- Profil (Email) --}}
                        <div class="flex items-center space-x-2 border-l pl-4">
                            <i class="fas fa-user-circle text-xl text-gray-500"></i>
                            <span class="text-sm font-medium text-gray-800 hidden md:block">
                                {{ Auth::user()->email }}
                            </span>
                        </div>
                        
                        {{-- Déconnexion --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                class="p-2 text-gray-600 hover:text-gray-900 rounded-full hover:bg-gray-100 transition duration-150"
                                title="Déconnexion">
                                <i class="fas fa-sign-out-alt text-lg"></i>
                            </button>
                        </form>

                    @else
                        {{-- Menu Utilisateur Déconnecté (Basé sur image_480d8e.jpg) --}}

                        <a href="{{ route('login') }}" 
                           class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium transition duration-150">
                            Se connecter
                        </a>
                        <a href="{{ route('register') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg 
                                  shadow-sm text-white bg-gray-800 hover:bg-gray-700 transition duration-150 ease-in-out">
                            S'inscrire comme exposant
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Contenu de la Page -->
    <main>
        @yield('content')
    </main>

    {{-- <!-- Footer Simple (Optionnel, mais recommandé) -->
    <footer class="bg-white border-t border-gray-100 mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} Eat&Drink. Tous droits réservés.</p>
            <div class="space-x-4">
                <a href="#" class="hover:text-gray-700">Politique de Confidentialité</a>
                <a href="#" class="hover:text-gray-700">Conditions d'Utilisation</a>
            </div>
        </div>
    </footer> --}}

</body>
</html>
