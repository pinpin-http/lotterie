@extends('layouts.frontoffice.app')

@section('content')
      <!-- Section -->
      <section class="min-vh-100 d-flex  align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-11 col-md-8 col-lg-12 justify-content-center">
                    <div class="card bg-primary shadow-soft border-light p-4">
                        <div class="card-header text-center pb-0">
                            <h1>Billetterie de la Loterie</h1>
                        </div>
                        <div class="card-body">
                        </div>    

                            <div class="row">
                                @foreach ($draws as $draw)
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card shadow-soft border-light p-4">
                                            <h4 class="card-title">Tirage #{{ $draw->id }}</h4>
                                            <p>Date: {{ $draw->date }}</p>
                                            <p>Cashprize: {{ number_format($draw->jackpot, 2) }} €</p>
                                            <p>Participants: {{ $draw->tickets_count }}</p>
                                            <p>Tickets Restants: {{ max(0, 100 - $draw->tickets_count) }}</p>

                                            @if (isset($userTickets[$draw->id]))
                                                <!-- Affichage du ticket de l'utilisateur -->
                                                <div class="alert alert-info mt-3">
                                                    <strong>Votre Ticket:</strong>
                                                    <p>Numéros: {{ implode(', ', json_decode($userTickets[$draw->id]->numbers)) }}</p>
                                                    <p>Étoiles: {{ implode(', ', json_decode($userTickets[$draw->id]->stars)) }}</p>
                                                    @if ($draw->status === 'closed')
                                                        <p class="text-success">Le tirage est terminé ! Vérifiez vos résultats.</p>
                                                    @else
                                                        <p class="text-warning">En attente de lancement du tirage...</p>
                                                    @endif
                                                </div>
                                            @else
                                                <!-- Bouton pour acheter un ticket -->
                                                <form action="{{ route('user.buy_ticket', $draw->id) }}" method="POST" onsubmit="return confirm('Confirmez-vous l\'achat de ce ticket ?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary" {{ $draw->tickets_count >= 100 ? 'disabled' : '' }}>
                                                        Acheter un Ticket
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection
