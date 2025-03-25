<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolicyAssignment extends Model
{
    protected $fillable = [
        'client_id',
        'policy_id',
        'insurer_id',
        'user_id',
        'cost',
        'currency',
        'is_discounted',
        'discount_type',
        'discount',
        'policy_duration_start',
        'policy_duration_end',
        'payment_method',
        'status',
        'created_by',
        'updated_by',
    ];

    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }

    public function insurer()
    {
        return $this->belongsTo(Insurer::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'invoiceable');
    }

    public function documents()
    {
        return $this->hasMany(AssignmentDocument::class, 'policy_assignment_id');
    }
}
