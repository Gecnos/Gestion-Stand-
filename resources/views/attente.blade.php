@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[60vh] text-center px-4">
    <h1 class="text-3xl font-semibold mb-4">Votre demande est en cours de traitement</h1>
    <p class="mb-6 text-gray-600 max-w-xl">
        Merci pour votre intérêt à participer à <strong>Eat&Drink</strong>. Notre équipe examine actuellement votre dossier.
        Vous recevrez un email dès que votre stand sera approuvé.
    </p>
    <a href="{{ route('logout') }}" class="underline text-sm text-blue-600 hover:text-blue-800">Se déconnecter</a>
</div>
@endsection
