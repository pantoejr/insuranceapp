<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dependent extends Model
{
    protected $fillable = [
        'employee_id',
        'dependent_name',
        'gender',
        'email',
        'phone',
        'address',
        'relationship',
        'profile_picture',
        'status',
        'date_of_birth',
        'created_by',
        'updated_by'
    ];

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
