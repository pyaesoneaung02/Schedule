<?php

namespace App\Models;
use App\Models\Major;
use App\Models\Room;
use App\Models\Subject;
use App\Models\Year;
use Illuminate\Database\Eloquent\Model;

class Teaching extends Model
{
    //teaching
    protected $fillable = ['name','year_id','major_id','room_id','subject_id'];

    //to delete teaching only
    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    //to delete teaching only
    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    //to delete teaching only
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    //to delete teaching only
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
