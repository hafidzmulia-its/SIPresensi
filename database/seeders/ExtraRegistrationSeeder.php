<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Extra;
use Faker\Factory as Faker;
use App\Models\ExtraRegistration;


class ExtraRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = User::where('role', 'student')->get();
        $extras = Extra::all();

        foreach ($students as $student) {
            $pickedExtras = $extras->random(rand(1, 2));
            foreach ($pickedExtras as $extra) {
                ExtraRegistration::create([
                    'user_id' => $student->id,
                    'extra_id' => $extra->id,
                    'year' => now()->year,
                ]);
            }
        }
    }
}
