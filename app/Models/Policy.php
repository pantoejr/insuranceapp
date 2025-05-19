<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $fillable = [
        'policy_name',
        'policy_type_id',
        'policy_sub_type_id',
        'name',
        'number',
        'description',
        'coverage_details',
        'premium_amount',
        'currency',
        'premium_frequency',
        'commission_type',
        'rate',
        'value',
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

    public function policySubTypes()
    {
        return $this->hasMany(PolicySubType::class);
    }

    public function policyType()
    {
        return $this->belongsTo(PolicyType::class);
    }
}
