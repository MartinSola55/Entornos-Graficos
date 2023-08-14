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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students');
            $table->foreignId('responsible_id')->nullable()->constrained('responsibles');
            $table->foreignId('teacher_id')->nullable()->constrained('teachers');
            $table->foreignId('pps_id')->constrained('pps');
            $table->dateTime('finish_date')->nullable();
            $table->boolean('is_finished')->default(true);
            $table->boolean('is_approved')->default(false);
            $table->string('observation')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
