<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientService extends Model
{
    public $fillable = [
        'service_id',
        'client_id',
        'cost',
        'currency',
        'is_discounted',
        'discount_type',
        'discount',
        'notes',
        'service_duration_start',
        'service_duration_end',
        'payment_method',
        'status',
        'created_by',
        'updated_by'
    ];
}
