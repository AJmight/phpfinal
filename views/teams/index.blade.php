@extends('layouts.app', ['activePage' => 'teams', 'title' => 'Teams & Standings', 'navName' => 'Teams', 'activeButton' => ''])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header ">
                        <h4 class="card-title">Team Standings</h4>
                        <p class="card-category">Current league table</p>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th>Pos</th>
                                <th>Team</th>
                                <th>MP</th>
                                <th>W</th>
                                <th>D</th>
                                <th>L</th>
                                <th>GF</th>
                                <th>GA</th>
                                <th>GD</th>
                                <th>Pts</th>
                            </thead>
                            <tbody>
                                @forelse($teams as $index => $team)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <a href="{{ route('teams.show', $team) }}">
                                            @if($team->logo_url)
                                                <img src="{{ asset('storage/' . $team->logo_url) }}" alt="{{$team->name}} Logo" style="width: 20px; height: 20px; margin-right: 5px;">
                                            @endif
                                            {{ $team->name }}
                                        </a>
                                    </td>
                                    <td>{{ $team->matches_played }}</td>
                                    <td>{{ $team->wins }}</td>
                                    <td>{{ $team->draws }}</td>
                                    <td>{{ $team->losses }}</td>
                                    <td>{{ $team->goals_for }}</td>
                                    <td>{{ $team->goals_against }}</td>
                                    <td>{{ $team->goal_difference }}</td>
                                    <td><strong>{{ $team->points }}</strong></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">No teams found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection