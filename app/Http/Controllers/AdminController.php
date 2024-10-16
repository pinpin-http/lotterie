<?php
namespace App\Http\Controllers;

use App\Models\Draw;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Exception;

class AdminController extends Controller
{
    /**
     * Affiche le formulaire pour créer un nouveau tirage, incluant les tirages existants
     * avec le nombre de participants par tirage.
     */
    public function createDrawForm()
    {
        try {
            $draws = Draw::withCount('tickets')->get(); // Compte le nombre de tickets par tirage
            return view('admin.create_draw', compact('draws'));
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Erreur lors de la récupération des tirages : ' . $e->getMessage());
        }
    }

    /**
     * Crée un nouveau tirage, avec des numéros et des étoiles saisis ou générés aléatoirement.
     * Les numéros et étoiles sont validés et le tirage est ensuite enregistré en base de données.
     */
    public function storeDraw(Request $request)
    {
        $request->validate([
            'numbers' => 'required|array|size:5',
            'stars' => 'required|array|size:2',
            'numbers.*' => 'integer|between:1,49',
            'stars.*' => 'integer|between:1,9'
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
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Erreur lors de la création du tirage : ' . $e->getMessage());
        }
    }

    /**
     * Génère une série de nombres aléatoires uniques dans un intervalle donné.
     */
    private function generateRandomNumbers($count, $min, $max)
    {
        try {
            $numbers = [];
            while (count($numbers) < $count) {
                $num = rand($min, $max);
                if (!in_array($num, $numbers)) {
                    $numbers[] = $num;
                }
            }
            return $numbers;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la génération de numéros aléatoires : " . $e->getMessage());
        }
    }

    /**
     * Lance un tirage si le nombre minimum de participants est atteint.
     * La fonction évalue les gagnants et clôture le tirage.
     */
    public function launchDraw(Draw $draw)
    {
        DB::beginTransaction();
        try {
            $participantCount = $draw->tickets()->count();

            if ($participantCount < 10) {
                DB::rollBack();
                return redirect()->route('admin.create_draw')
                    ->withErrors(['Le tirage doit avoir au moins 10 participants pour être lancé.']);
            }

            $this->calculateWinners($draw);
            $draw->status = 'closed';
            $draw->save();

            DB::commit();
            return redirect()->route('admin.create_draw')->with('success', 'Tirage lancé et résultats calculés');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Erreur lors du lancement du tirage : ' . $e->getMessage());
        }
    }

    /**
     * Calcule les gagnants d'un tirage en fonction de leur proximité avec les numéros gagnants.
     */
    private function calculateWinners(Draw $draw)
    {
        try {
            $winningNumbers = json_decode($draw->numbers);
            $winningStars = json_decode($draw->stars);

            $tickets = Ticket::where('draw_id', $draw->id)->get();

            foreach ($tickets as $ticket) {
                $ticketNumbers = json_decode($ticket->numbers);
                $ticketStars = json_decode($ticket->stars);

                $totalDifference = 0;
                foreach ($ticketNumbers as $number) {
                    $closestDifference = min(array_map(fn($winningNumber) => abs($winningNumber - $number), $winningNumbers));
                    $totalDifference += $closestDifference;
                }

                $ticket->proximity_score = -$totalDifference;
                $matchingStars = count(array_intersect($winningStars, $ticketStars));
                $ticket->star_score = $matchingStars;

                $ticket->save();
            }
        } catch (Exception $e) {
            throw new Exception("Erreur lors du calcul des gagnants : " . $e->getMessage());
        }
    }

    /**
     * Génère des participants fictifs pour un tirage.
     */
    public function generateFakeParticipants(Request $request)
    {
        $request->validate([
            'draw_id' => 'required|exists:draws,id',
        ]);

        DB::beginTransaction();
        try {
            $draw = Draw::findOrFail($request->draw_id);

            if ($draw->tickets()->count() >= 100) {
                return response()->json(['success' => false, 'message' => 'Le tirage a déjà atteint 100 participants.']);
            }

            $remainingSlots = 100 - $draw->tickets()->count();
            $fakeParticipantCount = min($remainingSlots, 10);

            for ($i = 0; $i < $fakeParticipantCount; $i++) {
                Ticket::create([
                    'user_id' => 1, // ID d'utilisateur fictif
                    'draw_id' => $draw->id,
                    'numbers' => json_encode($this->generateRandomNumbers(5, 1, 49)),
                    'stars' => json_encode($this->generateRandomNumbers(2, 1, 9)),
                ]);
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Erreur lors de la génération de participants : ' . $e->getMessage()], 500);
        }
    }

    /**
     * Distribue les prix en fonction du classement pour un tirage.
     */
    public function distributePrizes(Draw $draw)
    {
        DB::beginTransaction();
        try {
            $existingPrizes = DB::table('prizes')->where('draw_id', $draw->id)->exists();

            if ($existingPrizes) {
                return redirect()->route('admin.create_draw')->withErrors('Les prix ont déjà été distribués pour ce tirage.');
            }

            $jackpot = $draw->jackpot;
            $prizeDistribution = [40, 20, 12, 7, 6, 5, 4, 3, 2, 1];

            $winners = $draw->tickets()
                ->orderByDesc('proximity_score')
                ->orderByDesc('star_score')
                ->take(10)
                ->get();

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
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors("Erreur lors de la distribution des prix : " . $e->getMessage());
        }
    }
}
