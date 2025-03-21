<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemVariable extends Model
{
    protected $fillable = [
        'name',
        'type',
        'value',
        'created_by',
        'updated_by'
    ];
}
