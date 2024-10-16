@extends('layouts.frontoffice.app')

@section('content')
<div class="container">
    <h1>Classement des Gagnants par Tirage</h1>

    <div class="table-responsive mt-4">
        @foreach ($draws as $draw)
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
                        @forelse ($draw->prizes as $prize)
                            <tr>
                                <td>{{ $prize->rank }}</td>
                                <td>{{ $prize->user_id }}</td>
                                <td>{{ number_format($prize->amount, 2) }}</td>
                                <td>{{ $prize->percentage }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Aucun gagnant pour ce tirage.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</div>
@endsection
