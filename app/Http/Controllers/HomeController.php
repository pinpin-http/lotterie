<?php
namespace App\Http\Controllers;

use App\Models\Draw;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil de l'application.
     */
    public function index()
    {
        return view('pages.frontoffice.home');
    }

    /**
     * Affiche le classement des tirages clôturés avec leurs récompenses,
     * trié par ordre de rang.
     */
    public function viewRanking(Request $request)
    {
        $drawId = $request->input('draw_id');
        $draws = [];

        if ($drawId) {
            $draws = Draw::where('id', $drawId)
                ->where('status', 'closed')
                ->with(['prizes' => function ($query) {
                    $query->orderBy('rank', 'asc');
                }])
                ->get();
        } else {
            $draws = Draw::where('status', 'closed')->with('prizes')->orderBy('id', 'desc')->limit(5)->get();
        }

        // Récupération des tirages fermés pour suggestion d'affichage
        $drawRecommendations = Draw::where('status', 'closed')->orderBy('id', 'desc')->pluck('id');

        return view('pages.frontoffice.ranking', compact('draws', 'drawRecommendations'));
    }
}
