<?php

use App\Models\AcademicYears;
use App\Models\Day;
use App\Models\Major;
use App\Models\Room;
use App\Models\Sections;
use App\Models\Semesters;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Time;
use App\Models\Year;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teachings', function (Blueprint $table) {
            $table->id();
            $table->integer('academic_year_id')->nullable();
            $table->integer('semester_id')->nullable();
            $table->integer('teacher_id');
            $table->integer('year_id');
            $table->integer('major_id');
            $table->integer('room_id');
            $table->integer('subject_id');
            $table->integer('section_id');
            $table->integer('day_id')->nullable();
            $table->integer('time_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachings');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }


    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }


    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function ‌academicYear()
    {
        return $this->belongsTo(AcademicYears::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semesters::class);
    }

    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function time()
    {
        return $this->belongsTo(Time::class);
    }

    public function section()
    {
        return $this->belongsTo(Sections::class);
    }
};
