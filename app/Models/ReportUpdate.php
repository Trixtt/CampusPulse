<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportUpdate extends Model
{
    protected $fillable = [
        'post_id',
        'status',
        'message',
    ];
}