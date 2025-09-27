<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Conteneur principal du formulaire (Centré et avec une carte blanche) --}}
    {{-- J'ai retiré le mt-6 car le padding-top est géré par guest-layout --}}
    <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-xl overflow-hidden rounded-lg"> 
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Connexion</h1>
            <p class="text-sm text-gray-500 mt-1">Connectez-vous à votre compte Eat&Drink</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email Address --}}
            <div class="mb-4">
                <x-input-label for="email" value="Email" class="text-gray-700 font-semibold" />
                <x-text-input id="email"
                    class="block mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    type="email" name="email" :value="old('email')" {{-- Retire le 'votre@email.com' en dur --}}
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div class="mb-6">
                <x-input-label for="password" value="Mot de passe" class="text-gray-700 font-semibold" />
                <x-text-input id="password"
                    class="block mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Bouton de connexion --}}
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-lg font-medium text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-700 transition duration-150 ease-in-out">
                Se connecter
            </button>
        </form>

        {{-- Section "Pas encore de compte ?" --}}
        <div class="text-center mt-6">
            <p class="text-gray-600">
                Pas encore de compte ?
                <a href="{{ route('demande.stand') }}" class="text-gray-800 hover:text-gray-900 font-medium">
                    S'inscrire comme exposant
                </a>
            </p>
        </div>

        {{-- Vous pouvez ajouter ici la section Comptes de test si elle est nécessaire --}}

    </div>
</x-guest-layout>
