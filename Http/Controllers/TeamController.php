<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Game;

class TeamController extends Controller
{
    /**
     * Display a listing of the teams with standings.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Fetch teams sorted by points, then goal difference, then name
        $teams = Team::orderBy('points', 'desc')
                     ->orderBy('goal_difference', 'desc')
                     ->orderBy('goals_for', 'desc') // Tie-breaker
                     ->orderBy('name', 'asc')
                     ->get();

        return view('teams.index', ['teams' => $teams]);
    }

    /**
     * Display the specified team's details.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Team $team)
    {
        // Load necessary relationships
        $team->load(['players'/*, 'coach' - Add if coach model exists */]);

        // Fetch past results for this team
        $pastGames = Game::with(['team1', 'team2'])
                        ->where(function ($query) use ($team) {
                            $query->where('team_1_id', $team->id)
                                  ->orWhere('team_2_id', $team->id);
                        })
                        ->where('status', 'completed')
                        ->orderBy('start_time', 'desc')
                        ->limit(10) // Example limit
                        ->get();

        return view('teams.show', [
            'team' => $team,
            'pastGames' => $pastGames,
            // Pass coach details if available
        ]);
    }
}