<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Extra;
use App\Models\User;

class ExtraRegistration extends Model
{
    protected $fillable = ['user_id','extra_id','semester','year'];

    public function student()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function extra()
    {
        return $this->belongsTo(Extra::class);
    }
}

