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
        Schema::table('attendance_reports', function (Blueprint $table) {
            // store relative path, e.g. "reports/1234.png"
            $table->string('image_path')->nullable()->after('berita_acara');
        });
    }

    public function down(): void
    {
        Schema::table('attendance_reports', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }

};
