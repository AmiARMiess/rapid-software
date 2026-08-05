<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentResponsible extends Model
{
    protected $fillable = [
        'department_id',
        'name',
    ];

    public $timestamps = false;
}
