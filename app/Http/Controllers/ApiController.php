<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request, App\Models;

class ApiController extends Controller {

    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function addGame() {

        $this->valid();

        $model = new Models\Game();

        $this->saveModel($model);

        if(!$this->savePivot($model))
            return response()->json(['status' => 'incorrect players']);

        return response()->json(['status' => 'OK']);
    }

    public function updateGame(Models\Game $game) {

        $this->valid();

        $this->saveModel($game);

        $savePivotVal = [];
        foreach (Models\Pivot::where('game_id', $game->id)->get() as $pivot) {
            $savePivotVal[] = $pivot->player_id;
            $pivot->delete();
        }

        if(!$this->savePivot($game)){
            foreach ($savePivotVal as $value) {
                $pivot = new Models\Pivot();
                $pivot->player_id = $value;
                $pivot->game_id = $game->id;
                $pivot->save();
            }
            return response()->json(['status' => 'incorrect players']);
        }

        return response()->json(['status' => 'OK']);
    }

    private function valid() {
        $this->validate($this->request, [
            'start' => 'required|date_format:Y-m-d H:i:s',
            'end' => 'required|date_format:Y-m-d H:i:s',
            'winner' => 'required|integer',
            'players' => 'required|array',
            'log' => "string"
        ]);
    }

    private function saveModel(Models\Game $game) :void {
        $game->start = $this->request->start;
        $game->end = $this->request->end;
        $game->winner = $this->request->winner;
        $game->log = $this->request->log;
        $game->save();
    }

    private function savePivot(Models\Game $game) :bool {
        foreach ($this->request->players as $player) {
            if(!is_integer($player))
                return false;
            $pivot = new Models\Pivot();
            $pivot->player_id = $player;
            $pivot->game_id = $game->id;
            $pivot->save();
        }

        return true;
    }
}
