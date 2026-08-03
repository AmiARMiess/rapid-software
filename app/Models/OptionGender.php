<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionGender extends Model
{
    protected $table = 'option_genders';

    protected $fillable = [
        'id',
        'gender',
    ];
}
