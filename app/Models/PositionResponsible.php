<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PositionResponsible extends Model
{
    protected $fillable = [
        'position_id',
        'name',
    ];

    public $timestamps = false;
}
