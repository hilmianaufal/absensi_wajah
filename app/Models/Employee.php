<?php

namespace App\Models;

use App\Models\Attendance;
use App\Models\WorkShift;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'employee_code',
        'name',
        'email',
        'phone',
        'position',
        'department',
        'photo',
        'status',
        'work_shift_id',
        'face_descriptor',
    ];

    public function workShift()
{
    return $this->belongsTo(WorkShift::class);
}

public function attendances()
{
    return $this->hasMany(Attendance::class);
}
}