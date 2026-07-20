<?php

namespace App\Models;
use App\Models\Major;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //rooms
    protected $fillable = ['name','year_id','major_id','section_id'];

    //to delete room only
    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    //to delete romm only
    public function major()
    {
        return $this->belongsTo(Major::class);
    }
}
