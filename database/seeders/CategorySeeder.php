<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Category::create(['name' => '၀က်ပေါင်ခြောက်']);
        // Category::create(['name' => '၀က်အူချောင်း']);
        // Category::create(['name' => 'ကြက်အူချောင်း']);
        Category::create(['name' => 'အာပြဲခြောက်']);
        // Category::create(['name' => 'အမဲပေါင်ခြောက်']);
        // Category::create(['name' => 'ဆတ်သားခြောက်']);
        // Category::create(['name' => 'အမဲမွှခြောက်']);
    }
}
