<?php

namespace App\Models;
use App\Models\Department;
use App\Models\Major;
use App\Models\Position;
use App\Models\Teaching;
use App\Models\User;
use App\Models\Year;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    //teacher
    protected $fillable = ['name','position_id','department_id', 'user_id'];

    //to delete teacher only
    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    //to delete teacher only
    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    //to delete teacher only
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //to delete teacher only
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    //to delete teacher only
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    //to delete teacher only
    public function teachings(): HasMany
    {
        return $this->hasMany(Teaching::class, 'teacher_id');
    }
}
