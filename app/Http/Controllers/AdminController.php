<?php

namespace App\Http\Controllers;

use App\Models\Draw;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Exception;
use Exception as Enter;

class AdminController extends Controller
{
     // Affiche le formulaire pour créer un tirage
     public function createDrawForm()
     {
         try {
             $draws = Draw::withCount('tickets')->get(); // Ajout du compteur de participants
         } catch (Enter $e) {
             return redirect()->back()->withErrors('Erreur lors de la récupération des tirages : ' . $e->getMessage());
         }

         return view('admin.create_draw', compact('draws'));
     }

     // Crée un tirage avec des numéros manuels ou aléatoires
     public function storeDraw(Request $request)
     {
         // Validation pour s'assurer qu'il y a exactement 5 chiffres et 2 étoiles
         $request->validate([
             'numbers' => 'required|array|size:5',
             'stars' => 'required|array|size:2',
             'numbers.*' => 'integer|between:1,49',  // Chaque nombre doit être entre 1 et 49
             'stars.*' => 'integer|between:1,9'      // Chaque étoile doit être entre 1 et 9
         ], [
             'numbers.required' => 'Vous devez fournir 5 numéros.',
             'numbers.size' => 'Le tirage doit contenir exactement 5 numéros.',
             'stars.required' => 'Vous devez fournir 2 étoiles.',
             'stars.size' => 'Le tirage doit contenir exactement 2 étoiles.',
             'numbers.*.integer' => 'Les numéros doivent être des entiers.',
             'numbers.*.between' => 'Les numéros doivent être entre 1 et 49.',
             'stars.*.integer' => 'Les étoiles doivent être des entiers.',
             'stars.*.between' => 'Les étoiles doivent être entre 1 et 9.'
         ]);

         $numbers = $request->input('numbers') ?? $this->generateRandomNumbers(5, 1, 49);
         $stars = $request->input('stars') ?? $this->generateRandomNumbers(2, 1, 9);

         DB::beginTransaction();
         try {
             $draw = Draw::create([
                 'date' => now(),
                 'numbers' => json_encode($numbers),
                 'stars' => json_encode($stars),
                 'jackpot' => 3000000,
                 'status' => 'open',
             ]);

             DB::commit();
             return redirect()->route('admin.create_draw')->with('success', 'Tirage créé avec succès');
         } catch (Enter $e) {
             DB::rollBack();
             return redirect()->back()->withErrors('Erreur lors de la création du tirage : ' . $e->getMessage());
         }
     }

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

     // Lance le tirage uniquement si le nombre de tickets est suffisant
     public function launchDraw(Draw $draw)
     {
         try {
             // Vérification du nombre de participants
             $participantCount = $draw->tickets()->count();

             if ($participantCount < 10) {
                 return redirect()->route('admin.create_draw')
                     ->withErrors('Le tirage doit avoir au moins 10 participants pour être lancé.');
             }

             $this->calculateWinners($draw);
             $draw->status = 'closed';
             $draw->save();

             return redirect()->route('admin.create_draw')->with('success', 'Tirage lancé et résultats calculés');
         } catch (Enter $e) {
             return redirect()->back()->withErrors('Erreur lors du lancement du tirage : ' . $e->getMessage());
         }
     }
     private function calculateWinners(Draw $draw)
     {
         try {
             $winningNumbers = json_decode($draw->numbers);
             $winningStars = json_decode($draw->stars);

             $tickets = Ticket::where('draw_id', $draw->id)->get();

             foreach ($tickets as $ticket) {
                 $ticketNumbers = json_decode($ticket->numbers);
                 $ticketStars = json_decode($ticket->stars);

                 // Calcul du score basé sur l'écart entre les numéros
                 $totalDifference = 0;

                 foreach ($ticketNumbers as $number) {
                     // Pour chaque numéro du ticket, on calcule l'écart avec le nombre gagnant le plus proche
                     $closestDifference = min(array_map(fn($winningNumber) => abs($winningNumber - $number), $winningNumbers));
                     $totalDifference += $closestDifference;
                 }

                 // Inverser la logique pour que plus le score est bas, plus il est proche des gagnants
                 $ticket->proximity_score = -$totalDifference;

                 // Calcul du score pour les étoiles (en cas d'égalité)
                 $matchingStars = count(array_intersect($winningStars, $ticketStars));
                 $ticket->star_score = $matchingStars;

                 $ticket->save();
             }
         } catch (Enter $e) {
             throw new Enter("Erreur lors du calcul des gagnants : " . $e->getMessage());
         }
     }


     //cheater mod

     public function generateFakeParticipants(Request $request)
    {
        $request->validate([
            'draw_id' => 'required|exists:draws,id',
        ]);

        $draw = Draw::findOrFail($request->draw_id);

        if ($draw->tickets()->count() >= 100) {
            return response()->json(['success' => false, 'message' => 'Le tirage a déjà atteint 100 participants.']);
        }

        // Générer des participants fictifs jusqu'à atteindre 100 participants
        $remainingSlots = 100 - $draw->tickets()->count();
        $fakeParticipantCount = min($remainingSlots, 10); // Ajoute 10 participants au maximum à la fois

        for ($i = 0; $i < $fakeParticipantCount; $i++) {
            Ticket::create([
                'user_id' => 1, // ID d'utilisateur fictif
                'draw_id' => $draw->id,
                'numbers' => json_encode($this->generateRandomNumbers(5, 1, 49)),
                'stars' => json_encode($this->generateRandomNumbers(2, 1, 9)),
            ]);
        }

        return response()->json(['success' => true]);
    }

    //distribution des prix ect
    public function distributePrizes(Draw $draw)
    {
        // Vérifier si des prix ont déjà été distribués pour ce tirage
        $existingPrizes = DB::table('prizes')->where('draw_id', $draw->id)->exists();

        if ($existingPrizes) {
            return redirect()->route('admin.create_draw')->withErrors('Les prix ont déjà été distribués pour ce tirage.');
        }

        $jackpot = $draw->jackpot;
        $prizeDistribution = [40, 20, 12, 7, 6, 5, 4, 3, 2, 1]; // Pourcentage pour les 10 premiers

        $winners = $draw->tickets()
            ->orderByDesc('proximity_score')
            ->orderByDesc('star_score')
            ->take(10)
            ->get();

        DB::beginTransaction();
        try {
            foreach ($winners as $index => $winner) {
                $rank = $index + 1;
                $percentage = $prizeDistribution[$index] ?? 0;
                $amount = ($jackpot * $percentage) / 100;

                DB::table('prizes')->insert([
                    'draw_id' => $draw->id,
                    'user_id' => $winner->user_id,
                    'rank' => $rank,
                    'amount' => $amount,
                    'percentage' => $percentage,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();
            return redirect()->route('admin.create_draw')->with('success', 'Prix distribués avec succès');
        } catch (Enter $e) {
            DB::rollBack();
            return redirect()->back()->withErrors("Erreur lors de la distribution des prix : " . $e->getMessage());
        }
    }

    //visualiser les ranks
    public function viewRanking()
    {
        // Récupérer tous les tirages terminés avec les gagnants triés par rang
        $draws = Draw::where('status', 'closed')
            ->with(['prizes' => function ($query) {
                $query->orderBy('rank', 'asc');
            }])->get();

        return view('admin.ranking', compact('draws'));
    }



}
