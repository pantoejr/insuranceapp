<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $fillable = [
        'name',
        'number',
        'description',
        'coverage_details',
        'premium_amount',
        'premium_frequency',
        'policy_duration',
        'terms_conditions',
        'eligibility',
        'status',
        'created_by',
        'updated_by',
    ];

    public function insurerPolicies()
    {
        return $this->hasMany(InsurerPolicy::class);
    }
}
