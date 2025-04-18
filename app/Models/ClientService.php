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

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'invoiceable');
    }
}
