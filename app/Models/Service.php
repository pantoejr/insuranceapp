<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $fillable = [
        'name',
        'description',
        'terms_conditions',
        'eligibility',
        'cost',
        'currency',
        'frequency',
        'status',
        'created_by',
        'updated_by'
    ];
}
