@extends('layouts.frontoffice.app')

@section('content')
<div class="section section-header pb-7">
    <h1>Gestion des Tirages</h1>

    <!-- Message de succès après la création d'un tirage -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Bouton pour créer un nouveau tirage -->
    <div class="my-4">
        <a href="{{ route('admin.create_draw') }}" class="btn btn-primary">Créer un Nouveau Tirage</a>
    </div>

    <h2 class="mt-5">Tirages En Cours</h2>
    <ul class="list-group">
        @foreach ($draws as $draw)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>Tirage #{{ $draw->id }}</strong> - Date: {{ $draw->date }} - Jackpot: {{ number_format($draw->jackpot, 2) }} €
                    <br>
                    Numéros gagnants : {{ implode(', ', json_decode($draw->numbers)) }}
                    <br>
                    Étoiles gagnantes : {{ implode(', ', json_decode($draw->stars)) }}
                </div>

                @if ($draw->status === 'open')
                    <form action="{{ route('admin.launch_draw', $draw) }}" method="POST" onsubmit="return confirm('Confirmez-vous le lancement de ce tirage ?');">
                        @csrf
                        <button type="submit" class="btn btn-success">Lancer le Tirage</button>
                    </form>
                @else
                    <span class="badge badge-secondary">Terminé</span>
                @endif
            </li>
        @endforeach
    </ul>
</div>
@endsection
