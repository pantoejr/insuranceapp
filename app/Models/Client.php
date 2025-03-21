<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'client_type',
        'full_name',
        'email',
        'phone',
        'status',
        'photo_picture',
        'address',
        'date_of_birth',
        'created_by',
        'updated_by',
    ];

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function policyAssignments()
    {
        return $this->hasMany(PolicyAssignment::class);
    }
}
