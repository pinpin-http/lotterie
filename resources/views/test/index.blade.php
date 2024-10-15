
@extends('layouts.frontoffice.app')

@section('content')
    <div class="container">
        <h1>Test des Données de Loterie</h1>

        <h2>Utilisateurs</h2>
        <ul>
            @foreach ($users as $user)
                <li>{{ $user->name }} ({{ $user->role }})
                    <ul>
                        @foreach ($user->tickets as $ticket)
                            <li>Ticket pour le tirage #{{ $ticket->draw_id }} - Numéros: {{ implode(', ', json_decode($ticket->numbers)) }} - Étoiles: {{ implode(', ', json_decode($ticket->stars)) }}</li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>

        <h2>Tirages</h2>
        <ul>
            @foreach ($draws as $draw)
                <li>Tirage #{{ $draw->id }} - Date: {{ $draw->date }} - Jackpot: {{ $draw->jackpot }}
                    <ul>
                        <li>Numéros gagnants: {{ implode(', ', json_decode($draw->numbers)) }}</li>
                        <li>Étoiles gagnantes: {{ implode(', ', json_decode($draw->stars)) }}</li>
                        <li>Tickets:
                            <ul>
                                @foreach ($draw->tickets as $ticket)
                                    <li>{{ $ticket->user->name }} - Numéros: {{ implode(', ', json_decode($ticket->numbers)) }} - Étoiles: {{ implode(', ', json_decode($ticket->stars)) }}</li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
