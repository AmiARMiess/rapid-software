<?php

namespace App\Models;

use App\Models\Position;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    protected $fillable = [
        'full_name',
        'gender',
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'position', 'id');
    }

    /**
     * Get the gender associated with the employee.
     */
    public function optionGender(): BelongsTo
    {
        return $this->belongsTo(OptionGender::class, 'gender', 'id');
    }

    /**
     * Get the bank associated with the employee.
     */
    public function optionBankName(): BelongsTo
    {
        return $this->belongsTo(OptionBankName::class, 'bank_name', 'id');
    }

    /**
     * Get the religion associated with the employee.
     */
    public function optionReligion(): BelongsTo
    {
        return $this->belongsTo(OptionReligion::class, 'religion', 'id');
    }

    /**
     * Get the marital status associated with the employee.
     */
    public function optionMaritalStatus(): BelongsTo
    {
        return $this->belongsTo(OptionMaritalStatus::class, 'marital_status', 'id');
    }

    /**
     * Get the employment type associated with the employee.
     */
    public function optionEmploymentType(): BelongsTo
    {
        return $this->belongsTo(OptionEmploymentType::class, 'employment_type', 'id');
    }
}
