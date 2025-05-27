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
        Schema::create('extra_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')     // student
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('extra_id')
                ->constrained()
                ->onDelete('cascade');
            $table->year('year');
            $table->timestamps();

            $table->unique(['user_id','extra_id','year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extra_registrations');
    }
};
