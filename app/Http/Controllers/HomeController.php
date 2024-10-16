<?php

namespace App\Http\Controllers;


use App\Models\Draw;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Exception;
use Exception as Enter;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('pages.frontoffice.home');
    }
        //visualiser les ranks
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

            // Récupérer tous les IDs de tirages fermés pour les suggestions
            $drawRecommendations = Draw::where('status', 'closed')->orderBy('id', 'desc')->pluck('id');

            return view('pages.frontoffice.ranking', compact('draws', 'drawRecommendations'));
        }

}
