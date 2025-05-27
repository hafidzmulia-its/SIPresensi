<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Extra;
use Faker\Factory as Faker;


class ExtraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $pembinas = User::where('role', 'pembina')->get();

        foreach (range(1, 5) as $i) {
            Extra::create([
                'name' => $faker->unique()->word . ' Club',
                'pembina_id' => $pembinas->random()->id,
            ]);
        }
    }
}
