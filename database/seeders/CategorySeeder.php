<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::firstOrCreate(['name' => '仕事']);
        Category::firstOrCreate(['name' => 'プライベート']);
        Category::firstOrCreate(['name' => '買い物']);
    }
}
