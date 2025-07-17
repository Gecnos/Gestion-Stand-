@component('mail::message')
# Bonjour {{ $user->name }}

Votre demande de stand à **Eat&Drink** a été approuvée !

Vous pouvez maintenant vous connecter à votre tableau de bord :

@component('mail::button', ['url' => url('/login')])
Se connecter
@endcomponent

Merci,  
L'équipe Eat&Drink
@endcomponent
