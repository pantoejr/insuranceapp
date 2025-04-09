<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolicyType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'created_by',
        'updated_by',
    ];

    public function policySubTypes()
    {
        return $this->hasMany(PolicySubType::class);
    }
}
