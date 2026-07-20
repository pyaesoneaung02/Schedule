<?php

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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('long_name');
            $table->string('short_name');
            $table->longText('description')->nullable();
            $table->integer('year_id');
            $table->integer('major_id');
            $table->integer('time_number');
            $table->integer('academic_year_id')->nullable();
            $table->integer('semester_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
