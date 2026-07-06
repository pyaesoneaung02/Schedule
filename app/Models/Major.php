<?php

namespace App\Models;
use App\Models\Year;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    //major
    protected $fillable = ['name','year_id'];

    //to delete major only
    public function year()
    {
        return $this->belongsTo(Year::class);
    }
}
