<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $fillable = [
        'client_id',
        'policy_id',
        'amount',
        'currency',
        'claim_type',
        'description',
        'status',
        'created_by',
        'updated_by',
    ];

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }
}
