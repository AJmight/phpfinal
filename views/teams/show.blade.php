@extends('layouts.app', ['activePage' => 'teams', 'title' => $team->name . ' Details', 'navName' => 'Team Details', 'activeButton' => ''])

@section('content')
<div class="content">
    <div class="container-fluid">
        {{-- Team Header --}}
        <div class="row mb-3 align-items-center">
            <div class="col-md-2 text-center">
                 @if($team->logo_url)
                    <img src="{{ asset('storage/' . $team->logo_url) }}" alt="{{$team->name}} Logo" class="img-fluid rounded-circle" style="max-width: 100px;">
                @else
                    <i class="nc-icon nc-shield" style="font-size: 5rem;"></i> {{-- Placeholder icon --}}
                 @endif
            </div>
            <div class="col-md-10">
                <h2>{{ $team->name }}</h2>
                <p><strong>Venue:</strong> {{ $team->home_venue ?? 'N/A' }}</p>
                {{-- Add Coach Info Here if available --}}
                 {{-- <p><strong>Coach:</strong> {{ $team->coach->name ?? 'N/A' }} (Age: {{ $team->coach->age ?? 'N/A' }})</p> --}}
            </div>
        </div>

        {{-- Nav Tabs for Players/Results/Standings --}}
        <ul class="nav nav-tabs" id="teamTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="players-tab" data-toggle="tab" data-target="#players" type="button" role="tab" aria-controls="players" aria-selected="true">Players</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="results-tab" data-toggle="tab" data-target="#results" type="button" role="tab" aria-controls="results" aria-selected="false">Past Results</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="standings-tab" data-toggle="tab" data-target="#standings" type="button" role="tab" aria-controls="standings" aria-selected="false">Standings</button>
            </li>
        </ul>

        <div class="tab-content" id="teamTabContent">
            {{-- Players Tab --}}
            <div class="tab-pane fade show active" id="players" role="tabpanel" aria-labelledby="players-tab">
                <div class="card">
                    <div class="card-header"><h4 class="card-title">Player Squad</h4></div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($team->players as $player)
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <div class="card h-100">
                                        {{-- Player Photo --}}
                                        @if($player->photo_url)
                                             <img src="{{ asset('storage/' . $player->photo_url) }}" class="card-img-top" alt="{{ $player->name }}" style="max-height: 200px; object-fit: cover;">
                                        @else
                                             <div class="text-center p-5 bg-light"><i class="nc-icon nc-single-02" style="font-size: 4rem;"></i></div> {{-- Placeholder --}}
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title">#{{ $player->shirt_number }} {{ $player->name }}</h5>
                                            <p class="card-text">
                                                <strong>Position:</strong> {{ $player->position }}<br>
                                                <strong>Nationality:</strong> {{ $player->nationality ?? 'N/A' }}<br>
                                                <strong>DOB:</strong> {{ $player->date_of_birth ? $player->date_of_birth->format('M d, Y') : 'N/A' }}<br>
                                                <strong>Status:</strong> <span class="badge badge-{{ $player->status == 'active' ? 'success' : 'secondary' }}">{{ ucfirst($player->status) }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12"><p>No players listed for this team.</p></div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Results Tab --}}
            <div class="tab-pane fade" id="results" role="tabpanel" aria-labelledby="results-tab">
                 <div class="card">
                     <div class="card-header"><h4 class="card-title">Recent Results</h4></div>
                     <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @forelse($pastGames as $game)
                                <li class="list-group-item">
                                    {{ $game->team1->name }} <strong>{{ $game->result_1 }} - {{ $game->result_2 }}</strong> {{ $game->team2->name }}
                                    <small class="d-block text-muted">
                                        {{ $game->start_time->format('M d, Y') }} @if($game->venue)- {{ $game->venue }} @endif
                                    </small>
                                </li>
                            @empty
                                <li class="list-group-item">No past results found.</li>
                            @endforelse
                        </ul>
                     </div>
                 </div>
            </div>

            {{-- Standings Tab --}}
            <div class="tab-pane fade" id="standings" role="tabpanel" aria-labelledby="standings-tab">
                 <div class="card">
                     <div class="card-header"><h4 class="card-title">Current Standings</h4></div>
                     <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Matches Played:</strong> {{ $team->matches_played }}</li>
                            <li class="list-group-item"><strong>Wins:</strong> {{ $team->wins }}</li>
                            <li class="list-group-item"><strong>Draws:</strong> {{ $team->draws }}</li>
                            <li class="list-group-item"><strong>Losses:</strong> {{ $team->losses }}</li>
                            <li class="list-group-item"><strong>Goals For:</strong> {{ $team->goals_for }}</li>
                            <li class="list-group-item"><strong>Goals Against:</strong> {{ $team->goals_against }}</li>
                            <li class="list-group-item"><strong>Goal Difference:</strong> {{ $team->goal_difference }}</li>
                            <li class="list-group-item"><strong>Points:</strong> {{ $team->points }}</li>
                        </ul>
                     </div>
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    // Ensure Bootstrap tabs work correctly if not automatically initialized
    $(document).ready(function(){
        $('#teamTab button').on('click', function (event) {
            event.preventDefault();
            $(this).tab('show');
        });
    });
</script>
@endpush