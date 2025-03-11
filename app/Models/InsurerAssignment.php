<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsurerAssignment extends Model
{
    protected $fillable = [
        'insurer_id',
        'user_id',
        'status',
        'created_by',
        'updated_by',
    ];
}
