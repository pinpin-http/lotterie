<?php
namespace App\Http\Controllers;

use App\Models\Draw;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Initialise le contrôleur avec un middleware restreignant l'accès aux utilisateurs authentifiés ayant le rôle d'utilisateur.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:user']);
    }

    /**
     * Affiche la page de réservation des tickets avec des informations sur les tirages ouverts et les tickets existants de l'utilisateur.
     */
    public function showTicketingPage()
    {
        // Récupère les tirages ouverts avec le nombre de tickets associés
        $draws = Draw::withCount('tickets')
            ->where('status', 'open')
            ->get();

        // Récupère les tickets de l'utilisateur pour les tirages en cours
        $userTickets = Ticket::where('user_id', auth()->id())
            ->whereIn('draw_id', $draws->pluck('id'))
            ->get()
            ->keyBy('draw_id');

        return view('user.ticketing', compact('draws', 'userTickets'));
    }

    /**
     * Permet à un utilisateur d'acheter un ticket pour un tirage ouvert, si disponible,
     * et si l'utilisateur ne possède pas déjà un ticket pour ce tirage.
     */
    public function buyTicket(Draw $draw)
    {
        $user = auth()->user();

        // Vérifie que l'utilisateur n'a pas déjà un ticket pour le tirage
        if (Ticket::where('user_id', $user->id)->where('draw_id', $draw->id)->exists()) {
            return redirect()->route('user.ticketing')->withErrors('Vous avez déjà acheté un ticket pour ce tirage.');
        }

        // Vérifie que le tirage est ouvert et non complet
        if ($draw->status !== 'open' || $draw->tickets()->count() >= 100) {
            return redirect()->route('user.ticketing')->withErrors('Ce tirage est complet ou fermé.');
        }

        // Génère des numéros et étoiles pour le ticket
        $numbers = $this->generateRandomNumbers(5, 1, 49);
        $stars = $this->generateRandomNumbers(2, 1, 9);

        // Enregistre le ticket
        Ticket::create([
            'user_id' => $user->id,
            'draw_id' => $draw->id,
            'numbers' => json_encode($numbers),
            'stars' => json_encode($stars),
        ]);

        return redirect()->route('user.ticketing')->with('success', 'Ticket acheté avec succès');
    }

    /**
     * Génère des numéros aléatoires uniques dans une plage spécifiée.
     */
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

    /**
     * Affiche les participations de l'utilisateur avec des informations sur le tirage et le classement.
     */
    public function showParticipations()
    {
        $userId = auth()->id();

        // Récupère les tickets de l'utilisateur avec les informations de tirage et de classement
        $tickets = Ticket::with(['draw' => function ($query) {
                $query->select('id', 'date', 'status', 'jackpot');
            }, 'draw.prizes' => function ($query) use ($userId) {
                $query->where('user_id', $userId)->select('draw_id', 'rank', 'amount', 'percentage');
            }])
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();

        return view('user.participations', compact('tickets'));
    }
}
