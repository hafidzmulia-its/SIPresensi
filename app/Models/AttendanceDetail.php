<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AttendanceReport;
use App\Models\User;

class AttendanceDetail extends Model
{
    protected $fillable = ['attendance_report_id','student_id','presence'];

    public function report()
    {
        return $this->belongsTo(AttendanceReport::class,'attendance_report_id');
    }
    public function student()
    {
        return $this->belongsTo(User::class,'student_id');
    }
}

