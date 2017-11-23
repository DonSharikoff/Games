<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pivot extends Model {
    protected $table='player_games';
    public $timestamps = false;
}