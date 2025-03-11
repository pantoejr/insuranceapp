<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'client_id',
        'employee_name',
        'email',
        'phone',
        'position',
        'gender',
        'address',
        'status',
        'profile_picture',
        'date_of_birth',
        'created_by',
        'updated_by',
    ];

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function dependents()
    {
        return $this->hasMany(Dependent::class);
    }
}
