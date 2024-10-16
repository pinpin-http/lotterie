<?php

namespace App\Http\Controllers;

use App\Models\Draw;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Exception;
use Exception as Enter;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:user']); // Accès restreint aux utilisateurs normaux
    }

    public function participate()
    {
        // Logique pour afficher la page de participation
        return view('user.participate'); // Retourne la vue de participation
    }

    public function showTicketing()
    {
        // Récupérer les tirages ouverts avec les informations sur les tickets restants et participants
        $draws = Draw::withCount('tickets')
            ->where('status', 'open')
            ->get();

        // Récupérer le ticket de l'utilisateur pour chaque tirage en cours
        $userTickets = Ticket::where('user_id', auth()->id())
            ->whereIn('draw_id', $draws->pluck('id'))
            ->get()
            ->keyBy('draw_id');

        return view('user.ticketing', compact('draws', 'userTickets'));
    }




}
