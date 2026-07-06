<?php

namespace App\Models;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    //teacher
    protected $fillable = ['name','position_id','department_id'];

    //to delete teacher only
    public function year()
    {
        return $this->belongsTo(Position::class);
    }

    //to delete teacher only
    public function major()
    {
        return $this->belongsTo(Department::class);
    }
}
