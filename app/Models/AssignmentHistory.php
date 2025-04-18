<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentHistory extends Model
{
    protected $fillable = [
        'policy_assignment_id',
        'user_id',
        'status',
        'comment',
        'created_by',
        'updated_by',
    ];
}
