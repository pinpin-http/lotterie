<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Draw;
use App\Models\Ticket;

class TestController extends Controller
{
    public function index()
    {
        $draws = Draw::with('tickets.user')->get();
        $users = User::with('tickets')->get();

        return view('test.index', compact('draws', 'users'));
    }
}
