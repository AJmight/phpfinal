<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game; // Use the Game model
use App\Models\Player; // Use the Player model (for ratings, requires implementation)
use Carbon\Carbon; // For date comparisons

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     * Removed auth middleware for public welcome page.
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth'); // Remove this if '/' is public
    // }

    /**
     * Show the application dashboard (if still used).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // This is for the '/dashboard' route if you keep it
        return view('dashboard'); // Uses views/dashboard.blade.php
    }

    /**
     * Show the public welcome/home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function welcome()
    {
        // Fetch Upcoming Fixtures (Limit the number if needed)
        $upcomingFixtures = Game::with(['team1', 'team2']) // Eager load teams
                                ->where('start_time', '>=', Carbon::now())
                                ->where('status', 'scheduled') // Only show scheduled
                                ->orderBy('start_time', 'asc')
                                ->limit(5) // Example: Show next 5
                                ->get();

        // Fetch Top Players (Requires rating logic/storage)
        // $topPlayers = Player::orderBy('rating', 'desc')->limit(5)->get(); // Placeholder logic

        // Fetch Attendance Stats (Requires data source/logic)
        // $attendanceStats = [ // Placeholder logic
        //     'average' => Game::where('status', 'completed')->avg('attendance'),
        //     'highest' => Game::where('status', 'completed')->max('attendance'),
        // ];

        // Pass data to the welcome view
        return view('welcome', [
            'nextFixtures' => $upcomingFixtures,
            // 'topPlayers' => $topPlayers, // Uncomment when implemented
            // 'attendanceStats' => $attendanceStats, // Uncomment when implemented
        ]); // Uses views/welcome.blade.php (the modified version)
    }
}