<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Team;
use App\Models\Referee;
use Illuminate\Http\Request; // Use specific Request classes later

class FixtureAdminController extends Controller
{
    /**
     * Display a listing of the games (fixtures).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $games = Game::with(['team1', 'team2', 'referee']) // Eager load relationships
                     ->orderBy('start_time', 'desc')
                     ->paginate(15);

        // View: resources/views/admin/games/index.blade.php
        return view('admin.games.index', compact('games'));
    }

    /**
     * Show the form for creating a new game.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $teams = Team::orderBy('name')->pluck('name', 'id');
        $referees = Referee::orderBy('name')->pluck('name', 'id');
        // View: resources/views/admin/games/create.blade.php
        return view('admin.games.create', compact('teams', 'referees'));
    }

    /**
     * Store a newly created game in storage.
     *
     * @param  \Illuminate\Http\Request  $request // Replace with StoreGameRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) // Replace with StoreGameRequest
    {
        // Validation in StoreGameRequest
        Game::create($request->all()); // Ensure 'fillable' is set

        return redirect()->route('admin.games.index')->with('status', 'Game scheduled successfully.');
    }

    /**
     * Display the specified game.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\View\View
     */
    public function show(Game $game)
    {
        // Optional: View: resources/views/admin/games/show.blade.php
        $game->load(['team1', 'team2', 'referee']);
        return view('admin.games.show', compact('game'));
    }

    /**
     * Show the form for editing the specified game.
     * Also used for updating results/status.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\View\View
     */
    public function edit(Game $game)
    {
        $teams = Team::orderBy('name')->pluck('name', 'id');
        $referees = Referee::orderBy('name')->pluck('name', 'id');
        // View: resources/views/admin/games/edit.blade.php
        return view('admin.games.edit', compact('game', 'teams', 'referees'));
    }

    /**
     * Update the specified game in storage (details, results, status).
     *
     * @param  \Illuminate\Http\Request  $request // Replace with UpdateGameRequest
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Game $game) // Replace with UpdateGameRequest
    {
        // Validation in UpdateGameRequest (handle results, status rules)
        $game->update($request->all()); // Ensure 'fillable' includes results, status, etc.

        // Add logic here to update team standings based on result if status is 'completed'
        if ($request->status === 'completed' && $request->filled('result_1') && $request->filled('result_2')) {
            // $this->updateStandings($game); // Implement this helper method
        }


        return redirect()->route('admin.games.index')->with('status', 'Game updated successfully.');
    }

    /**
     * Remove the specified game from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Game $game)
    {
         // Add authorization check here
        $game->delete(); // Use soft delete if enabled

        return redirect()->route('admin.games.index')->with('status', 'Game deleted successfully.');
    }

    /**
     * Helper method to update team standings (Example structure)
     *
     * @param Game $game
     */
    // protected function updateStandings(Game $game)
    // {
    //     $team1 = $game->team1;
    //     $team2 = $game->team2;
    //     $score1 = $game->result_1;
    //     $score2 = $game->result_2;

    //     // Logic to update matches_played, wins, draws, losses, goals_for, goals_against, goal_difference, points
    //     // ... complex logic based on $score1 vs $score2 ...

    //     // $team1->save();
    //     // $team2->save();
    // }
}