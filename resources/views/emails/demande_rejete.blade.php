@component('mail::message')
# Bonjour {{ $user->name }}

Votre demande de stand à **Eat&Drink** a été rejete !

La raison est {{ $user->motif_rejet }}

Veuillez nous contacter physiquement pour faire appel à cette demande de rejet
Merci,  
L'équipe Eat&Drink
@endcomponent
