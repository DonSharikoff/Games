<?php

use Illuminate\Http\Request, App\Models;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$this->model('player', Models\Player::class);
$this->model('game', Models\Game::class);

$this->group([
    'prefix' => 'player'
    ], function () {
    $this->get('{player}', function (Models\Player $player) {
        return response()->json(['ELO' => $player->ELO]);
    });

    $this->get('{player}/games', function (Models\Player $player) {
        return response()->json(['games' => $player->games]);
    });
});

$this->group([
    'prefix' => 'game'
    ], function () {

    $this->get('all', function () {
        return response()->json(['Games' => Models\Game::get()]);
    });

    $this->get('{game}', function (Models\Game $game) {
        return response()->json(['Game' => $game]);
    });

    $this->post('add',[
        'uses'  => 'ApiController@addGame',
    ]);
    $this->put('{game}',[
        'uses'  => 'ApiController@updateGame',
    ]);

    $this->delete('{game}', function (Models\Game $game) {
        $game->delete();
        return response()->json(['Status' => 'OK']);
    });
    $this->post('between', function (Request $request) {
        return response()->json([
            'Games' => Models\Game::where('start', '>=', $request->start)->where('end', '<=', $request->end)->get()
        ]);
    });
});


