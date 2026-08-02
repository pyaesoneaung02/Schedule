<?php

namespace App\Models;
use App\Models\AcademicYears;
use App\Models\Major;
use App\Models\Semesters;
use App\Models\Teaching;
use App\Models\Year;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //subject
    protected $fillable = ['long_name','short_name','year_id','major_id','time_number','description','academic_year_id','semester_id','image'];

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

    //to delete subject only
    public function academicYear()
    {
        return $this->belongsTo(AcademicYears::class, 'academic_year_id');
    }

    //to delete subject only
    public function semester()
    {
        return $this->belongsTo(Semesters::class, 'semester_id');
    }
}
