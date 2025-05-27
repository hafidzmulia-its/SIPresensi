<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Extra;
use App\Models\User;
use App\Models\ExtraRegistration;
use App\Models\AttendanceReport;


class Extra extends Model
{
    protected $fillable = ['name','pembina_id'];

    public function pembina()
    {
        return $this->belongsTo(User::class, 'pembina_id');
    }

    public function anggota()   // members this semester/year
    {
        return $this->belongsToMany(User::class, 'extra_registrations')
                    ->withPivot('year')
                    ->withTimestamps()
                    ->wherePivot('year', date('Y')); // current year
    }

    public function registrations()
    {
        return $this->hasMany(ExtraRegistration::class);
    }

    public function reports()
    {
        return $this->hasMany(AttendanceReport::class);
    }
}

