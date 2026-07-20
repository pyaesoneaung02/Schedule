<?php
namespace App\Models;

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

}
