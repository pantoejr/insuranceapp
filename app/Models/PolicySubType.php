<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolicySubType extends Model
{
    protected $fillable = [
        'policy_type_id',
        'name',
        'description',
        'created_by',
        'updated_by',
    ];

    public function policyType()
    {
        return $this->belongsTo(PolicyType::class);
    }
}
