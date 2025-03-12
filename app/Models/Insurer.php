<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insurer extends Model
{

    protected $fillable = [
        'company_name',
        'registration_number',
        'address',
        'email',
        'phone',
        'key_contact_person',
        'key_contact_email',
        'description',
        'website_url',
        'logo',
        'status',
        'created_by',
        'updated_by',
    ];

    public function assignments()
    {
        return $this->hasMany(InsurerAssignment::class);
    }
}
