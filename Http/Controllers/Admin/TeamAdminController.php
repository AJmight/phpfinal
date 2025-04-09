<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request; // Use specific Request classes later, e.g., StoreTeamRequest

class TeamAdminController extends Controller
{
    /**
     * Display a listing of the teams.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $teams = Team::orderBy('name')->paginate(15); // Example pagination
        // View: resources/views/admin/teams/index.blade.php
        return view('admin.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new team.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // View: resources/views/admin/teams/create.blade.php
        return view('admin.teams.create');
    }

    /**
     * Store a newly created team in storage.
     *
     * @param  \Illuminate\Http\Request  $request // Replace with StoreTeamRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) // Replace with StoreTeamRequest
    {
        // Validation will be in StoreTeamRequest
        Team::create($request->all()); // Ensure 'fillable' is set in Team model

        return redirect()->route('admin.teams.index')->with('status', 'Team created successfully.');
    }

    /**
     * Display the specified team. (Admin might not need a dedicated show view)
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\View\View
     */
    public function show(Team $team)
    {
        // Optional: View: resources/views/admin/teams/show.blade.php
        // Often combined with edit or index for admin
        return view('admin.teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified team.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\View\View
     */
    public function edit(Team $team)
    {
        // View: resources/views/admin/teams/edit.blade.php
        return view('admin.teams.edit', compact('team'));
    }

    /**
     * Update the specified team in storage.
     *
     * @param  \Illuminate\Http\Request  $request // Replace with UpdateTeamRequest
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Team $team) // Replace with UpdateTeamRequest
    {
        // Validation will be in UpdateTeamRequest
        $team->update($request->all()); // Ensure 'fillable' is set

        // Handle standings overrides if included in the request
        // if ($request->has('points_override')) { ... }

        return redirect()->route('admin.teams.index')->with('status', 'Team updated successfully.');
    }

    /**
     * Remove the specified team from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Team $team)
    {
        // Add authorization check here
        $team->delete(); // Use soft delete if enabled

        return redirect()->route('admin.teams.index')->with('status', 'Team deleted successfully.');
    }
}