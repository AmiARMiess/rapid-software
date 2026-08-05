<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Position;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\DepartmentResponsible;

class Department extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'status',
        'description',
    ];

    public function departmentResponsibles(): HasMany
    {
        return $this->hasMany(DepartmentResponsible::class);
    }

    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }
}
