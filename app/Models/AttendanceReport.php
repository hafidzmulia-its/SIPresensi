<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Extra;
use App\Models\User;
use App\Models\AttendanceDetail;

class AttendanceReport extends Model
{
    protected $fillable = [
        'extra_id','date','berita_acara','submitted_by','status','image_path'
    ];

    public function extra()
    {
        return $this->belongsTo(Extra::class);
    }
    public function reporter()
    {
        return $this->belongsTo(User::class,'submitted_by');
    }
    public function details()
    {
        return $this->hasMany(AttendanceDetail::class);
    }
}

