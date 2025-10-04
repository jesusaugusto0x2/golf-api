<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domain\Category\Models\Category;

class CategorySeeder extends Seeder
{
    private const CATEGORIES = [
        'Drivers',
        'Woods',
        'Hybrids',
        'Driving Irons',
        'Irons',
        'Wedges',
        'Putters',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::CATEGORIES as $name) {
            Category::updateOrCreate(
                ['name' => $name],
                ['updated_at' => now(), 'created_at' => now()]
            );
        }
    }
}
