@extends('layouts.frontoffice.app')

@section('content')

<!-- Hero -->
<div class="section section-header pb-7">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 text-center">
                <h1>Classement des Gagnants par Tirage</h1>

                <!-- Formulaire de recherche -->
                <form action="{{ route('ranking') }}" method="GET" class="form-inline justify-content-center my-4">
                    <input type="number" name="draw_id" class="form-control mr-2" placeholder="ID du Tirage" value="{{ request('draw_id') }}" required>
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </form>

                <!-- Suggestions de tirages -->
                @if($drawRecommendations->isNotEmpty())
                    <div class="suggestions mt-3">
                        <p class="text-muted">Suggestions de tirages :</p>
                        <ul class="list-inline">
                            @foreach ($drawRecommendations as $recommendation)
                                <li class="list-inline-item">
                                    <a href="{{ route('ranking', ['draw_id' => $recommendation]) }}" class="btn btn-sm bg-primary">
                                        Tirage #{{ $recommendation }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Résultats de la recherche -->
                <div class="table-responsive mt-4">
                    @forelse ($draws as $draw)
                        <div class="card bg-primary shadow-soft border-light p-4 mb-4">
                            <h3>Tirage #{{ $draw->id }} - Date: {{ $draw->date }} - Jackpot: {{ number_format($draw->jackpot, 2) }} €</h3>

                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th>Rang</th>
                                        <th>User ID</th>
                                        <th>Montant Gagné (€)</th>
                                        <th>Pourcentage du Jackpot (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($draw->prizes as $prize)
                                        <tr>
                                            <td>{{ $prize->rank }}</td>
                                            <td>{{ $prize->user_id }}</td>
                                            <td>{{ number_format($prize->amount, 2) }}</td>
                                            <td>{{ $prize->percentage }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @empty
                        <div class="alert alert-info">Aucun tirage trouvé pour cet ID.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
