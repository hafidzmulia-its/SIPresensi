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
        Schema::create('attendance_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_report_id')
                ->constrained('attendance_reports')
                ->onDelete('cascade');
            $table->foreignId('student_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->enum('presence', ['hadir','izin','sakit','alfa'])
                ->nullable(false);      // every detail needs a presence status
            $table->text('remarks')     // optional extra notes per student
                ->nullable();
            $table->timestamps();

            $table->unique(['attendance_report_id','student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_details');
    }
};
