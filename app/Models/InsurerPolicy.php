<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsurerPolicy extends Model
{
    protected $fillable = [
        'insurer_id',
        'policy_id',
        'status',
        'created_by',
        'updated_by',
    ];

    public function insurer()
    {
        return $this->belongsTo(Insurer::class);
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }
}
