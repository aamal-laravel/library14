<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'sport' , 'description' => 'الرياضة والصحة الرياضية'],
            ['name' => 'web' , 'description' => 'كتب تصميم مواقع'],
            ['name' => 'food' , 'description' => ''],
            ['name' => 'Medical' , 'description' => ''],
        ];
        Category::insert($categories);
    }
}
