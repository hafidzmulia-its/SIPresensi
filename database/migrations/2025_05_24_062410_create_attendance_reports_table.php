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
        Schema::create('attendance_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('extra_id')
                ->constrained()
                ->onDelete('cascade');
            $table->date('date')
                ->nullable(false);       // you typically require the meeting date
            $table->text('berita_acara')
                ->nullable();           // allow reps to submit an empty “notes” if needed
            $table->foreignId('submitted_by')
                ->constrained('users')
                ->onDelete('cascade');
            $table->enum('status', ['pending','approved','rejected'])
                ->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_reports');
    }
};
