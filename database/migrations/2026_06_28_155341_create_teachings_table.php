<?php

use App\Models\Room;
use App\Models\Subject;
use App\Models\Teacher;
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
};
