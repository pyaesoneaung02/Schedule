<?php
namespace App\Models;

use App\Models\AcademicYears;
use App\Models\Major;
use App\Models\Room;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Year;
use Illuminate\Database\Eloquent\Model;

class Teaching extends Model
{

    protected $fillable = [
        'teacher_id',
        'year_id',
        'major_id',
        'room_id',
        'subject_id',
        'section_id',
        'academic_year_id',
        'semester_id',
    ];

    // Academic Year
    public function academicYear()
    {
        return $this->belongsTo(
            AcademicYears::class,
            'academic_year_id'
        );
    }

    // Semester
    public function semester()
    {
        return $this->belongsTo(
            Semester::class,
            'semester_id'
        );
    }

    // Teacher
    public function teacher()
    {
        return $this->belongsTo(
            Teacher::class,
            'teacher_id'
        );
    }

    // Year
    public function year()
    {
        return $this->belongsTo(
            Year::class,
            'year_id'
        );
    }

    // Major
    public function major()
    {
        return $this->belongsTo(
            Major::class,
            'major_id'
        );
    }

    // Room
    public function room()
    {
        return $this->belongsTo(
            Room::class,
            'room_id'
        );
    }

    // Subject
    public function subject()
    {
        return $this->belongsTo(
            Subject::class,
            'subject_id'
        );
    }

    // Section
    public function section()
    {
        return $this->belongsTo(
            Section::class,
            'section_id'
        );
    }

}
