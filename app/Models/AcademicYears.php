<?php
namespace App\Models;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;

class AcademicYears extends Model
{
    //academicyears
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'status',
    ];

    //to delete subject only
      public function subjects()
    {
        return $this->hasMany(Subject::class, 'academic_year_id');
    }

}
