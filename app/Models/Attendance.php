<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'status',
        'late_minutes',
        'photo',
        'note',
        'check_in_photo',
        'check_out_photo',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}