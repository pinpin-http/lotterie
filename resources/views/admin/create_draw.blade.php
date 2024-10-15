@extends('layouts.frontoffice.app')

@section('content')
<div class="container">
    <h1>Créer un Tirage</h1>

    <form action="{{ route('admin.store_draw') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="numbers">Numéros Gagnants (laisser vide pour générer aléatoirement)</label>
            <input type="text" name="numbers[]" class="form-control mb-2" placeholder="Numéro 1">
            <input type="text" name="numbers[]" class="form-control mb-2" placeholder="Numéro 2">
            <input type="text" name="numbers[]" class="form-control mb-2" placeholder="Numéro 3">
            <input type="text" name="numbers[]" class="form-control mb-2" placeholder="Numéro 4">
            <input type="text" name="numbers[]" class="form-control mb-2" placeholder="Numéro 5">
        </div>

        <div class="form-group">
            <label for="stars">Numéros Étoiles (laisser vide pour générer aléatoirement)</label>
            <input type="text" name="stars[]" class="form-control mb-2" placeholder="Étoile 1">
            <input type="text" name="stars[]" class="form-control mb-2" placeholder="Étoile 2">
        </div>

        <button type="submit" class="btn btn-primary">Créer le Tirage</button>
    </form>

    <hr>

    <h2>Tirages En Cours</h2>
    <ul>
        @foreach ($draws as $draw)
            <li>
                Tirage #{{ $draw->id }} - Date: {{ $draw->date }}
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
