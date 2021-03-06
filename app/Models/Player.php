<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model {
    protected $table='players';
    protected $hidden=['pivot'];
    public $timestamps = false;

    public function games() {
        return $this->belongsToMany('App\Models\Game', 'player_games', 'player_id', 'id');
    }
}