@extends('layouts.frontoffice.app')

@section('content')
    <!-- Section -->
    <section class="min-vh-100 d-flex  align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-11 col-md-8 col-lg-12 justify-content-center">
                    <div class="card bg-primary shadow-soft border-light p-4">
                        <div class="card-header text-center pb-0">
                            <h1>Vos Participations</h1>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tirage</th>
                                        <th>Date</th>
                                        <th>Jackpot</th>
                                        <th>Numéros</th>
                                        <th>Étoiles</th>
                                        <th>Statut</th>
                                        <th>Classement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <td>#{{ $ticket->draw->id }}</td>
                                            <td>{{ $ticket->draw->date }}</td>
                                            <td>{{ number_format($ticket->draw->jackpot, 2) }} €</td>
                                            <td>{{ implode(', ', json_decode($ticket->numbers)) }}</td>
                                            <td>{{ implode(', ', json_decode($ticket->stars)) }}</td>
                                            <td>
                                                @if ($ticket->draw->status === 'open')
                                                    <span class="badge badge-warning">En attente</span>
                                                @else
                                                    <span class="badge badge-success">Terminé</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($ticket->draw->status === 'closed' && $ticket->draw->prizes->isNotEmpty())
                                                    <div>
                                                        <strong>Rang:</strong> {{ $ticket->draw->prizes[0]->rank }}<br>
                                                        <strong>Montant Gagné:</strong> {{ number_format($ticket->draw->prizes[0]->amount, 2) }} €<br>
                                                        <strong>Pourcentage:</strong> {{ $ticket->draw->prizes[0]->percentage }} %
                                                    </div>
                                                @elseif($ticket->draw->status === 'closed')
                                                    <span class="text-muted">Non classé</span>
                                                @else
                                                    <span class="text-muted">En attente de résultats</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    
@endsection
