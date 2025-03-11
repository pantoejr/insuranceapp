<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'file_name',
        'file_path',
        'file_type',
        'attachmentable_type',
        'attachmentable_id',
        'created_by',
        'updated_by',
    ];

    public function attachmentable()
    {
        return $this->morphTo();
    }
}
