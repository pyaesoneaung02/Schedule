<?php

namespace App\Models;

use App\Models\Day;
use App\Models\Major;
use App\Models\Room;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Time;
use App\Models\Year;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    //schedule
    protected $fillable=[
        'year_id',
        'major_id',
        'room_id',
        'teacher_id',
        'subject_id',
        'day_id',
        'time_id'
    ];

     //to delete schedule only
    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    //to delete schedule only
    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    //to delete schedule only
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    //to delete schedule only
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    //to delete schedule only
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    //to delete schedule only
    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    //to delete schedule only
    public function time()
    {
        return $this->belongsTo(Time::class);
    }
}
