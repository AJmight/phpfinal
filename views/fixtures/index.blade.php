@extends('layouts.app', ['activePage' => 'fixtures', 'title' => 'Fixtures & Standings', 'navName' => 'Fixtures', 'activeButton' => ''])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            {{-- Fixtures Column --}}
            <div class="col-md-8">
                {{-- Upcoming Fixtures --}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Upcoming Fixtures</h4>
                    </div>
                    <div class="card-body">
                         <ul class="list-group list-group-flush">
                            @forelse($upcomingFixtures as $fixture)
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
                            @empty
                                <li class="list-group-item text-center">No upcoming fixtures.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                {{-- Past Fixtures --}}
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title">Past Results</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @forelse($pastFixtures as $fixture)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        {{ $fixture->team1->name ?? 'Team 1' }} <strong>{{ $fixture->result_1 ?? '?' }} - {{ $fixture->result_2 ?? '?' }}</strong> {{ $fixture->team2->name ?? 'Team 2' }}
                                        <small class="d-block text-muted">
                                            {{ \Carbon\Carbon::parse($fixture->start_time)->format('D, M j, Y') }}
                                             @if($fixture->venue)- {{ $fixture->venue }} @endif
                                        </small>
                                    </span>
                                     <span class="badge badge-secondary badge-pill">{{ ucfirst($fixture->status) }}</span>
                                </li>
                            @empty
                                <li class="list-group-item text-center">No past results available.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Standings Column --}}
            <div class="col-md-4">
                 <div class="card strpied-tabled-with-hover">
                    <div class="card-header ">
                        <h4 class="card-title">League Standings</h4>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                             <thead>
                                <th title="Position">Pos</th>
                                <th>Team</th>
                                <th title="Matches Played">MP</th>
                                <th title="Points">Pts</th>
                            </thead>
                            <tbody>
                                @forelse($standings as $index => $team)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <a href="{{ route('teams.show', $team) }}">
                                             @if($team->logo_url)<img src="{{ asset('storage/' . $team->logo_url) }}" alt="" style="width: 15px; height: 15px; margin-right: 3px;">@endif
                                            {{ $team->name }}
                                        </a>
                                    </td>
                                    <td>{{ $team->matches_played }}</td>
                                    <td><strong>{{ $team->points }}</strong></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No teams found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>