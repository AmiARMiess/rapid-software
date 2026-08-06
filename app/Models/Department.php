<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\DepartmentResponsible;
use App\Models\OptionStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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

    public function optionStatus(): BelongsTo
    {
        return $this->belongsTo(OptionStatus::class, 'status', 'id');
    }

    public function employees(): HasManyThrough
    {
        return $this->hasManyThrough(
            Employee::class,
            Position::class,
            'department', // Foreign key on positions table...
            'position',   // Foreign key on employees table...
            'id',         // Local key on departments table...
            'id'          // Local key on positions table...
        );
    }
}
