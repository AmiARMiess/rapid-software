<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Position extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'department',
        'reporting_to',
        'description',
        'status',
        'level',
    ];

    public function positionResponsibles(): HasMany
    {
        return $this->hasMany(PositionResponsible::class);
    }

    public function optionStatus(): BelongsTo
    {
        return $this->belongsTo(OptionStatus::class, 'status', 'id');
    }

    public function optionLevel(): BelongsTo
    {
        return $this->belongsTo(OptionLevel::class, 'level', 'id');
    }

    public function positionDepartment(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department', 'id')
        ->where('user_id', auth()->user()->id);
    }

    public function reportingTo(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'reporting_to', 'id')
        ->where('user_id', auth()->user()->id);
    }
}
