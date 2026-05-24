<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransitPoint extends Model
{
    protected $table = 'transit_points';

    protected $fillable = [
        'route_id',
        'name',
        'latitude',
        'longitude',
        'stop_order'
    ];
}
