<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request; // Use specific Request classes later

class PlayerAdminController extends Controller
{
    /**
     * Display a listing of the players.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Player::with('team'); // Eager load team relationship

        // Optional filtering by team
        if ($request->has('team_id')) {
             $query->where('team_id', $request->input('team_id'));
        }

        $players = $query->orderBy('name')->paginate(20);
        $teams = Team::orderBy('name')->pluck('name', 'id'); // For filter dropdown

        // View: resources/views/admin/players/index.blade.php
        return view('admin.players.index', compact('players', 'teams'));
    }

    /**
     * Show the form for creating a new player.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $teams = Team::orderBy('name')->pluck('name', 'id');
        // View: resources/views/admin/players/create.blade.php
        return view('admin.players.create', compact('teams'));
    }

    /**
     * Store a newly created player in storage.
     *
     * @param  \Illuminate\Http\Request  $request // Replace with StorePlayerRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) // Replace with StorePlayerRequest
    {
        // Validation in StorePlayerRequest
        // Handle photo upload if necessary
        Player::create($request->all()); // Ensure 'fillable' is set

        return redirect()->route('admin.players.index')->with('status', 'Player created successfully.');
    }

    /**
     * Display the specified player.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\View\View
     */
    public function show(Player $player)
    {
        // Optional: View: resources/views/admin/players/show.blade.php
        $player->load('team'); // Load relationship if needed
        return view('admin.players.show', compact('player'));
    }

    /**
     * Show the form for editing the specified player.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\View\View
     */
    public function edit(Player $player)
    {
        $teams = Team::orderBy('name')->pluck('name', 'id');
        // View: resources/views/admin/players/edit.blade.php
        return view('admin.players.edit', compact('player', 'teams'));
    }

    /**
     * Update the specified player in storage.
     *
     * @param  \Illuminate\Http\Request  $request // Replace with UpdatePlayerRequest
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Player $player) // Replace with UpdatePlayerRequest
    {
        // Validation in UpdatePlayerRequest
        // Handle photo upload if necessary
        $player->update($request->all()); // Ensure 'fillable' is set

        return redirect()->route('admin.players.index')->with('status', 'Player updated successfully.');
    }

    /**
     * Remove the specified player from storage.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Player $player)
    {
         // Add authorization check here
        $player->delete(); // Use soft delete if enabled

        return redirect()->route('admin.players.index')->with('status', 'Player deleted successfully.');
    }
}