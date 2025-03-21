<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $fillable = [
        'subject',
        'recipient',
        'cc',
        'bcc',
        'body',
        'status',
        'created_by',
        'updated_by',
    ];
}
