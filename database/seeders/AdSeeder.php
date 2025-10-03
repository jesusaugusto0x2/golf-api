<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Domain\Ad\Models\Ad;
use App\Domain\User\Models\User;
use App\Domain\Category\Models\Category;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $users = User::all();
        $categories = Category::all();

        if ($users->isEmpty() || $categories->isEmpty()) {
            $this->command->warn('⚠️ No users or categories found, run UserSeeder and CategorySeeder first.');
            return;
        }

        foreach ($users as $user) {
            $adsCount = rand(5, 10);

            for ($i = 0; $i < $adsCount; $i++) {
                Ad::create([
                    'user_id'     => $user->id,
                    'category_id' => $categories->random()->id,
                    'title'       => $faker->words(3, true),
                    'price'       => $faker->randomFloat(2, 50, 1000),
                    'condition'   => $faker->randomElement(['new', 'used', 'refurbished', 'like_new']),
                    'description' => $faker->paragraph(),
                    'ends_at' => $faker->dateTimeBetween('-1 month', '+2 month'),
                ]);
            }
        }
    }
}
