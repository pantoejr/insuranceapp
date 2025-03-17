<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentDocument extends Model
{
    protected $fillable = [
        'policy_assignment_id',
        'document_name',
        'document_path',
        'document_type',
        'created_by',
        'updated_by',
    ];
}
