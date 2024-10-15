<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Draw;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Affiche le formulaire pour créer un tirage
    public function createDrawForm()
    {       
        $draws = Draw::all();
        return view('admin.create_draw', compact('draws'));
    }

    // Crée un tirage avec des numéros manuels ou aléatoires
    public function storeDraw(Request $request)
    {
        $request->validate([
            'numbers' => 'nullable|array|size:5',
            'stars' => 'nullable|array|size:2',
        ]);

        // Si aucun numéro n'est fourni, générer des numéros aléatoires
        $numbers = $request->input('numbers') ?? $this->generateRandomNumbers(5, 1, 49);
        $stars = $request->input('stars') ?? $this->generateRandomNumbers(2, 1, 9);

        $draw = Draw::create([
            'date' => now(),
            'numbers' => json_encode($numbers),
            'stars' => json_encode($stars),
            'jackpot' => 3000000,
            'status' => 'open',
        ]);

        return redirect()->route('admin.draws')->with('success', 'Tirage créé avec succès');
    }

    // Génère des numéros aléatoires uniques
    private function generateRandomNumbers($count, $min, $max)
    {
        $numbers = [];
        while (count($numbers) < $count) {
            $num = rand($min, $max);
            if (!in_array($num, $numbers)) {
                $numbers[] = $num;
            }
        }
        return $numbers;
    }

    // Lance le tirage en calculant les résultats
    public function launchDraw(Draw $draw)
    {
        // Calculer les numéros gagnants pour chaque ticket
        $this->calculateWinners($draw);

        // Mettre à jour le statut du tirage
        $draw->status = 'closed';
        $draw->save();

        return redirect()->route('admin.draws')->with('success', 'Tirage lancé et résultats calculés');
    }

    // Calcul des gagnants
    private function calculateWinners(Draw $draw)
    {
        $winningNumbers = json_decode($draw->numbers);
        $winningStars = json_decode($draw->stars);

        // Comparer chaque ticket pour déterminer la proximité
        $tickets = Ticket::where('draw_id', $draw->id)->get();

        foreach ($tickets as $ticket) {
            $ticketNumbers = json_decode($ticket->numbers);
            $ticketStars = json_decode($ticket->stars);

            $matchingNumbers = count(array_intersect($winningNumbers, $ticketNumbers));
            $matchingStars = count(array_intersect($winningStars, $ticketStars));

            // Calculer une "distance" par exemple pour chaque ticket et sauvegarder
            $ticket->proximity_score = $matchingNumbers * 10 + $matchingStars * 5;
            $ticket->save();
        }
    }
}
