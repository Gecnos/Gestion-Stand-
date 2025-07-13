@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-5xl">
    <h1 class="text-2xl font-bold mb-6">Demandes de stands en attente</h1>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    @if($demandes->isEmpty())
        <p>Aucune demande en attente pour le moment.</p>
    @else
        <div class="overflow-x-auto rounded shadow">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Nom</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Email</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($demandes as $demande)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $demande->name }}</td>
                            <td class="px-4 py-2">{{ $demande->email }}</td>
                            <td class="px-4 py-2 space-x-2">
                                {{-- Approve --}}
                                <form action="{{ url('/admin/approve/'.$demande->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded bg-green-600 text-white text-sm hover:bg-green-700 transition">Approuver</button>
                                </form>
                                {{-- Reject --}}
                                <form action="{{ url('/admin/reject/'.$demande->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Rejeter cette demande ?');">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded bg-red-600 text-white text-sm hover:bg-red-700 transition">Rejeter</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection