@extends('layouts.app', ['activePage' => 'welcome', 'title' => 'COCIS Football League', 'navName' => 'Home', 'activeButton' => ''])

@section('content')
    {{-- Use a background image or keep it plain based on your design preference --}}
    {{-- Option 1: Full Page Image Background (like original welcome) --}}
    {{-- <div class="full-page section-image" data-color="black" data-image="{{asset('light-bootstrap/img/full-screen-image-2.jpg')}}"> --}}

    {{-- Option 2: Standard Content Area (like dashboard) --}}
    <div class="content">
        <div class="container-fluid">
            {{-- Page Title --}}
            <div class="row mb-4">
                <div class="col-md-12">
                    {{-- Adjusted title from original welcome page --}}
                    <h1 class="text-center">{{ __('Welcome to the COCIS Football League Hub') }}</h1>
                    <p class="text-center">Your one-stop portal for league information, fixtures, and stats.</p>
                </div>
            </div>

            {{-- Main Content Grid --}}
            <div class="row">
                {{-- Next Fixtures --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Upcoming Fixtures</h4>
                            <p class="card-category">Don't miss the next matches!</p>
                        </div>
                        <div class="card-body">
                            {{-- Check if fixtures data is available --}}
                            @isset($nextFixtures)
                                @if($nextFixtures->count() > 0)
                                    <ul class="list-group list-group-flush">
                                        @foreach($nextFixtures as $fixture)
                                            {{-- Assuming 'team1', 'team2' relations are loaded in controller --}}
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span>
                                                    {{ $fixture->team1->name ?? 'Team 1' }} vs {{ $fixture->team2->name ?? 'Team 2' }}
                                                    <small class="d-block text-muted">
                                                        {{ \Carbon\Carbon::parse($fixture->start_time)->format('D, M j, Y g:i A') }}
                                                        @if($fixture->venue)- {{ $fixture->venue }} @endif
                                                    </small>
                                                </span>
                                                <span class="badge badge-primary badge-pill">{{ ucfirst($fixture->status) }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No upcoming fixtures scheduled.</p>
                                @endif
                            @else
                                <p>Fixture information is currently unavailable.</p>
                                {{-- Placeholder while data isn't passed --}}
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Team A vs Team B <small class="d-block text-muted">Sat, Apr 12, 2025 3:00 PM - Main Field</small></span>
                                        <span class="badge badge-primary badge-pill">Scheduled</span>
                                    </li>
                                     <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Team C vs Team D <small class="d-block text-muted">Sun, Apr 13, 2025 4:00 PM - Stadium</small></span>
                                        <span class="badge badge-primary badge-pill">Scheduled</span>
                                    </li>
                                </ul>
                            @endisset
                        </div>
                    </div>
                </div>

                {{-- Player Ratings & Attendance --}}
                <div class="col-md-6">
                    {{-- Player Ratings Card --}}
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Top Rated Players</h4>
                            <p class="card-category">Players leading the charts</p> {{-- Player rating logic needs to be defined --}}
                        </div>
                        <div class="card-body">
                             {{-- Check if player rating data is available --}}
                            @isset($topPlayers)
                                 @if($topPlayers->count() > 0)
                                    <ol class="list-group list-group-numbered">
                                        @foreach($topPlayers as $player) {{-- Assuming $player object has name and rating --}}
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">{{ $player->name }}</div>
                                                    {{-- Add position or team if available --}}
                                                </div>
                                                <span class="badge badge-success badge-pill">{{ $player->rating ?? 'N/A' }}</span> {{-- Assuming a 'rating' property --}}
                                            </li>
                                        @endforeach
                                    </ol>
                                @else
                                    <p>Player ratings are not yet available.</p>
                                @endif
                            @else
                                <p>Player rating information is currently unavailable.</p>
                                {{-- Placeholder --}}
                                 <ol class="list-group list-group-numbered">
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto"><div class="fw-bold">Player X</div>Forward</div><span class="badge badge-success badge-pill">9.5</span>
                                    </li>
                                     <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto"><div class="fw-bold">Player Y</div>Midfielder</div><span class="badge badge-success badge-pill">9.2</span>
                                    </li>
                                </ol>
                            @endisset
                        </div>
                    </div>

                    {{-- Attendance Stats Card (Optional) --}}
                     <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Fan Attendance</h4>
                             <p class="card-category">Matchday turnout</p>
                        </div>
                        <div class="card-body">
                            {{-- Check if attendance data is available --}}
                            @isset($attendanceStats)
                                {{-- Display stats - e.g., Average, Highest --}}
                                <p>Average Attendance: {{ number_format($attendanceStats['average'] ?? 0) }}</p>
                                <p>Highest Attendance: {{ number_format($attendanceStats['highest'] ?? 0) }}</p>
                                {{-- You might want a chart here if you add a chart library --}}
                            @else
                               <p>Attendance data is currently unavailable.</p>
                               {{-- Placeholder --}}
                               <p>Average Attendance: 1,200</p>
                               <p>Highest Attendance: 2,500</p>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>

            {{-- Navigation Links Section --}}
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Explore the League</h4>
                        </div>
                        <div class="card-body text-center">
                             {{-- Use appropriate route names. These are assumptions. --}}
                             {{-- You might need to create these routes in web.php if they don't exist --}}
                            <a href="{{ route('teams.index') ?? '#' }}" class="btn btn-info btn-wd mx-2">{{ __('Teams') }}</a>
                            <a href="{{ route('fixtures.index') ?? '#' }}" class="btn btn-info btn-wd mx-2">{{ __('Fixtures & Standings') }}</a>
                            {{-- Using the page.index route from your web.php for About Us --}}
                            <a href="{{ route('page.index', 'about-us') }}" class="btn btn-info btn-wd mx-2">{{ __('About Us') }}</a>
                            <a href="{{ route('login') }}" class="btn btn-warning btn-wd mx-2">{{ __('Administrator Login') }}</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{-- </div> End of Option 1 wrapper if used --}}
@endsection

@push('js')
    {{-- Include this script if using the full-page background image --}}
    {{-- <script>
        $(document).ready(function() {
            demo.checkFullPageBackgroundImage();

            // Optional: Add animation delay if needed
            // setTimeout(function() {
            //     // after 1000 ms we add the class animated to the login/register card
            //     $('.card').removeClass('card-hidden');
            // }, 700);
        });
    </script> --}}
@endpush