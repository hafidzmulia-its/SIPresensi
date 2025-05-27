<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Extra;
use App\Models\ExtraRegistration;
use App\Models\AttendanceReport;
use Faker\Factory as Faker;
use App\Models\AttendanceDetail;

class AttendanceDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reports = AttendanceReport::with('extra')->get();

        foreach ($reports as $report) {
            // Get registered students for this extra
            $registrations = ExtraRegistration::where('extra_id', $report->extra_id)->get();

            foreach ($registrations as $reg) {
                AttendanceDetail::create([
                    'attendance_report_id' => $report->id,
                    'student_id' => $reg->user_id,
                    'presence' => ['hadir', 'izin', 'sakit', 'alfa'][rand(0, 3)],
                ]);
            }
        }
    }
}
