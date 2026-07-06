<?php

namespace App\Models;
use App\Models\Major;
use App\Models\Teaching;
use App\Models\Year;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //subject
    protected $fillable = ['long_name','short_name','year_id','major_id','time_number'];

     //to delete subject only
    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    //to delete subject only
    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    //to delete subject only
    public function teaching()
    {
        return $this->hasMany(Teaching::class);
    }
}
