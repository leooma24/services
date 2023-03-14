<?php

namespace Database\Seeders;

use App\Models\Movement;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\User;
use Faker\Factory as Faker;


class MovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 0;
        $data = [];
        $faker = Faker::create();
        $categories = collect(Category::all()->modelKeys());
        $users = collect(User::all()->modelKeys());
        while($count < 500) {
            $random = Carbon::today()->subDays(rand(0, 365))->format('Y-m-d');
            $data[] = [
                'category_id' => $categories->random(),
                'user_id' => $users->random(),
                'title' => $faker->name(),
                'type' => 1,
                'date' => $random,
                'amount' => rand(50, 1000),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $count++;
        }

        foreach(array_chunk($data, 1000) as $chunk) {
            Movement::insert($chunk);
        }

    }
}
