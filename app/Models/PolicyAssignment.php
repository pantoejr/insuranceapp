<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolicyAssignment extends Model
{
    protected $fillable = [
        'policy_type_id',
        'policy_sub_type_id',
        'client_id',
        'policy_id',
        'insurer_id',
        'user_id',
        'cost',
        'currency',
        'is_discounted',
        'discount_type',
        'discount',
        'notes',
        'policy_duration_start',
        'policy_duration_end',
        'is_expired',
        'vehicle_make',
        'vehicle_year',
        'vehicle_VIN',
        'vehicle_reg_number',
        'vehicle_use_type',
        'payment_method',
        'status',
        'created_by',
        'updated_by',
        'notification_sent_at'
    ];

    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }

    public function policyType()
    {
        return $this->belongsTo(PolicyType::class);
    }

    public function policySubType()
    {
        return $this->belongsTo(PolicySubType::class);
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
