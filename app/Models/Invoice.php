<?php

namespace App\Models;

use App\Helpers\InvoiceHelper;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $primaryKey = 'invoice_id'; // Set the primary key
    public $incrementing = false; // Disable auto-incrementing
    protected $keyType = 'string'; // Set the key type to string

    protected $fillable = [
        'invoice_id',
        'invoiceable_id',
        'invoiceable_type',
        'details',
        'total_amount',
        'currency',
        'amount_paid',
        'balance',
        'invoice_date',
        'due_date',
        'is_recurring',
        'send_reminders',
        'status',
        'notes',
        'created_by',
        'updated_by',
    ];

    /**
     * Boot the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($invoice) {
            $invoice->invoice_id = InvoiceHelper::generateInvoiceId();
        });
    }

    /**
     * Get the invoiceable model (e.g., PolicyAssignment, Claim, etc.).
     */
    public function invoiceable()
    {
        return $this->morphTo();
    }

    public function policyAssignment()
    {
        return $this->belongsTo(PolicyAssignment::class);
    }

    public function client()
    {
        return $this->invoiceable->client();
    }

    public function policy()
    {
        return $this->invoiceable->policy();
    }

    public function claim()
    {
        return $this->invoiceable->claim();
    }

    public function clientService()
    {
        return $this->invoiceable->clientService();
    }
}
