@component('mail::message')
# Bonjour {{ $user->name }}

Votre demande  par rapport a la suspension de votre demande de stand à **Eat&Drink** a été reçu !

Vous pouvez maintenant vous connecter à votre tableau de bord :

@component('mail::button', ['url' => url('/login')])
Se connecter
@endcomponent

Merci pour la patience,  
L'équipe Eat&Drink
@endcomponent
