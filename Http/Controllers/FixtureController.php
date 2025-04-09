<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Team;
use Carbon\Carbon;

class FixtureController extends Controller
{
    /**
     * Display upcoming and past fixtures, and league standings.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Fetch all games, ordered by time
        $allFixtures = Game::with(['team1', 'team2'])
                            ->orderBy('start_time', 'asc')
                            ->get();

        // Separate into upcoming and past
        $upcomingFixtures = $allFixtures->where('start_time', '>=', Carbon::now())->whereIn('status', ['scheduled', 'in_progress']);
        $pastFixtures = $allFixtures->where('start_time', '<', Carbon::now())->where('status', 'completed'); // Or include postponed/cancelled if desired

        // Fetch league standings
         $teamsStandings = Team::orderBy('points', 'desc')
                               ->orderBy('goal_difference', 'desc')
                               ->orderBy('goals_for', 'desc')
                               ->orderBy('name', 'asc')
                               ->get();

        return view('fixtures.index', [
            'upcomingFixtures' => $upcomingFixtures,
            'pastFixtures' => $pastFixtures,
            'standings' => $teamsStandings,
        ]);
    }
}
