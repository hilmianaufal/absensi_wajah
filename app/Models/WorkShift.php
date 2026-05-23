<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkShift extends Model
{
    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'late_tolerance',
        'status',
    ];
}