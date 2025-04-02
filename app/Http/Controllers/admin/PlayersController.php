<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPlayerRequest;
use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Models\Player;
use App\Models\Team;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlayersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('player_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $players = Player::with(['team'])->get();

        $teams = Team::get();

        return view('admin.players.index', compact('players', 'teams'));
    }

    public function create()
    {
        abort_if(Gate::denies('player_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teams = Team::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.players.create', compact('teams'));
    }

    public function store(StorePlayerRequest $request)
    {
        $player = Player::create($request->all());

        return redirect()->route('admin.players.index');
    }

    public function edit(Player $player)
    {
        abort_if(Gate::denies('player_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teams = Team::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $player->load('team');

        return view('admin.players.edit', compact('player', 'teams'));
    }

    public function update(UpdatePlayerRequest $request, Player $player)
    {
        $player->update($request->all());

        return redirect()->route('admin.players.index');
    }

    public function show(Player $player)
    {
        abort_if(Gate::denies('player_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $player->load('team');

        return view('admin.players.show', compact('player'));
    }

    public function destroy(Player $player)
    {
        abort_if(Gate::denies('player_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $player->delete();

        return back();
    }

    public function massDestroy(MassDestroyPlayerRequest $request)
    {
        $players = Player::find(request('ids'));

        foreach ($players as $player) {
            $player->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}