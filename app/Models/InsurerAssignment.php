<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsurerAssignment extends Model
{
    protected $fillable = [
        'insurer_id',
        'name',
        'email',
        'phone',
        'status',
        'created_by',
        'updated_by',
    ];

    public function insurer()
    {
        return $this->belongsTo(Insurer::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
