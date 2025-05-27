<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Extra;
use App\Models\ExtraRegistration;
use App\Models\AttendanceReport;
use Faker\Factory as Faker;

class AttendanceReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $extras = Extra::all();

        foreach ($extras as $extra) {
            foreach (range(1, 4) as $i) {
                AttendanceReport::create([
                    'extra_id' => $extra->id,
                    'date' => now()->subWeeks(rand(0, 5)),
                    'berita_acara' => $faker->sentence,
                    'submitted_by' => User::where('role','student')->inRandomOrder()->first()->id,
                    'status' => ['pending', 'approved', 'rejected'][rand(0, 2)],
                ]);
            }
        }
    }
}
