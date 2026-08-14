<?php
namespace App\Models;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //contact model
    protected $fillable = [
        'teacher_id',
        'user_id',
        'name',
        'email',
        'department',
        'subject',
        'message',
        'status',
    ];

    // to delete contact
    public function teacher()
    {
        return $this->belongsTo(
            Teacher::class,
            'teacher_id'
        );
    }

    // to delete contact
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}
