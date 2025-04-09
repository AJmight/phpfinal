<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Add models you might need for dashboard stats, e.g., User, Team, Game
use App\Models\User;
use App\Models\Team;
use App\Models\Game;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch data for dashboard widgets if needed
        // $userCount = User::count();
        // $teamCount = Team::count();
        // $upcomingGames = Game::where('status', 'scheduled')->count();

        // You'll need to create this view: resources/views/admin/dashboard.blade.php
        return view('admin.dashboard'/*, compact('userCount', 'teamCount', 'upcomingGames')*/);
    }
}