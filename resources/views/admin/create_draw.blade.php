@extends('layouts.frontoffice.app')

@section('content')

<!-- section principale,  store des draws ici-->
<div class="section section-header pb-7">
    <section class="section section-lg pt-0">
        <div class="container">
            <div class="row">
                <div class="col">
                <div class="card bg-primary shadow-soft border-light p-4">
            <h1 style="text-align: center">Créer un Tirage</h1>

                <div class="my-4">
                    <button id="generateRandom" class="btn btn-primary">Générer Automatiquement</button>
                </div>

                <form action="{{ route('admin.store_draw') }}" method="POST" id="drawForm">
                    @csrf

                    <div class="form-group">
                        <h3>Numéros Gagnants</h3>
                        <div class="d-flex flex-wrap">
                            @for ($i = 1; $i <= 49; $i++)
                                <label class="m-2">
                                    <input type="checkbox" name="numbers[]" value="{{ $i }}" class="number-checkbox">
                                    <span class="badge badge-secondary">{{ $i }}</span>
                                </label>
                            @endfor
                        </div>
                        <p class="mt-2">Sélectionnez 5 numéros.</p>
                    </div>

                    <div class="form-group mt-4">
                        <h3>Numéros Étoiles</h3>
                        <div class="d-flex flex-wrap">
                            @for ($i = 1; $i <= 9; $i++)
                                <label class="m-2">
                                    <input type="checkbox" name="stars[]" value="{{ $i }}" class="star-checkbox">
                                    <span class="badge badge-warning">{{ $i }}</span>
                                </label>
                            @endfor
                        </div>
                        <p class="mt-2">Sélectionnez 2 étoiles.</p>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4">Valider le Tirage</button>
                </form>
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <li style="color:red">{{ $error }}</li>
                    @endforeach
                @endif
                </div>
                </div>
            </div>
        </div>
    </section>
</div>



<div class="section section-lg pt-0">
    <section class="section section-lg pt-0">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card bg-primary shadow-soft border-light p-4">
                        <h2 class="mt-5">Tirages en Cours</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Jackpot</th>
                                        <th>Numéros Gagnants</th>
                                        <th>Étoiles Gagnantes</th>
                                        <th>Participants</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($draws as $draw)
                                    <tr>
                                        <td>{{ $draw->id }}</td>
                                        <td>{{ $draw->date }}</td>
                                        <td>{{ number_format($draw->jackpot, 2) }} €</td>
                                        <td>{{ implode(', ', json_decode($draw->numbers)) }}</td>
                                        <td>{{ implode(', ', json_decode($draw->stars)) }}</td>
                                        <td>{{ $draw->tickets_count }}</td>
                                        <td>
                                            @if ($draw->status === 'open')
                                                <span class="badge badge-success">Ouvert</span>
                                            @else
                                                <span class="badge badge-secondary">Terminé</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($draw->status === 'open' && $draw->tickets_count >= 10)
                                                <form action="{{ route('admin.launch_draw', $draw) }}" method="POST" onsubmit="return confirm('Confirmez-vous le lancement de ce tirage ?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger">Lancer le Tirage</button>
                                                </form>
                                            @elseif($draw->tickets_count < 10)
                                                <button class="btn btn-sm btn-warning" disabled>
                                                    Attente de Participants, {{ 10 - $draw->tickets_count }} tickets avant lancement
                                                </button>
                                            @elseif(DB::table('prizes')->where('draw_id', $draw->id)->exists())
                                                <button class="btn btn-sm btn-secondary" disabled>Prix déjà distribués</button>
                                            @else
                                                <form action="{{ route('admin.distribute_prizes', $draw) }}" method="POST" onsubmit="return confirm('Confirmez-vous la distribution des prix pour ce tirage ?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">Distribuer les Prix</button>
                                                </form>
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
    </section>
</div>


</div></section></div>

    <!-- Mode Cheater -->
    <div class="mt-5">
        <label for="cheater-password">Mode Admin :</label>
        <input type="password" id="cheater-password" placeholder="Entrez le mot de passe" class="form-control w-25 d-inline-block">
        <button id="unlock-cheater" class="btn btn-info ml-2">Déverrouiller</button>
    </div>

    <!-- Section cachée pour sélectionner un tirage et générer des participants -->
    <div id="cheater-section" class="mt-3" style="display: none;">
        <h4>Générer des Faux Participants</h4>
        <label for="select-draw">Sélectionner un tirage :</label>
        <select id="select-draw" class="form-control w-25 d-inline-block">
            @foreach ($draws as $draw)
                @if ($draw->tickets_count < 100) <!-- N'affiche que les tirages avec moins de 100 participants -->
                    <option value="{{ $draw->id }}">Tirage #{{ $draw->id }} - Participants : {{ $draw->tickets_count }}/100</option>
                @endif
            @endforeach
        </select>
        <button id="generate-fake-participants" class="btn btn-warning ml-2">Générer des faux participants</button>
    </div>
</div>

<script>
    document.getElementById('generateRandom').addEventListener('click', function() {
        // Deselect all checkboxes
        document.querySelectorAll('.number-checkbox, .star-checkbox').forEach(el => el.checked = false);

        // Function to get unique random numbers
        function getRandomNumbers(count, max) {
            const numbers = new Set();
            while (numbers.size < count) {
                numbers.add(Math.floor(Math.random() * max) + 1);
            }
            return Array.from(numbers);
        }

        // Select 5 random numbers (1-49) and 2 random stars (1-9)
        const randomNumbers = getRandomNumbers(5, 49);
        const randomStars = getRandomNumbers(2, 9);

        // Check corresponding checkboxes
        randomNumbers.forEach(num => {
            document.querySelector(`.number-checkbox[value="${num}"]`).checked = true;
        });
        randomStars.forEach(star => {
            document.querySelector(`.star-checkbox[value="${star}"]`).checked = true;
        });
    });

    // Ensure only 5 numbers and 2 stars are selected
    document.querySelectorAll('.number-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedNumbers = document.querySelectorAll('.number-checkbox:checked').length;
            if (checkedNumbers > 5) this.checked = false;
        });
    });

    document.querySelectorAll('.star-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedStars = document.querySelectorAll('.star-checkbox:checked').length;
            if (checkedStars > 2) this.checked = false;
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Disparition automatique après 5 secondes
        setTimeout(function() {
            $('#errorToast').fadeOut('slow');
        }, 5000);

        // Disparition au clic sur le bouton "fermer"
        $('.toast .close').on('click', function() {
            $(this).closest('.toast').fadeOut('slow');
        });
    });

    document.getElementById('unlock-cheater').addEventListener('click', function() {
        const password = document.getElementById('cheater-password').value;

        if (password === 'cheater') {
            document.getElementById('cheater-section').style.display = 'block';
            alert("Mode Cheater activé !");
        } else {
            alert("Mot de passe incorrect !");
        }
    });

    document.getElementById('generate-fake-participants').addEventListener('click', function() {
        const drawId = document.getElementById('select-draw').value;

        fetch('{{ route('admin.generate_fake_participants') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ draw_id: drawId })
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  alert("Faux participants générés !");
                  location.reload();
              } else {
                  alert("Erreur : " + data.message);
              }
          });
    });
</script>
@endsection
