<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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


}
