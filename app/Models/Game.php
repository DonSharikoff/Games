<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model {
    protected $table='games';
    protected $hidden=['pivot'];
    public $timestamps = false;

    public function players() {
        return $this->belongsToMany('App\Models\Player', 'player_games', 'game_id', 'id');
    }
}