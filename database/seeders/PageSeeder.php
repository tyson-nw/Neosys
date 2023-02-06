<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $welcome = [];
        $welcome['title'] = "Welcome"; 
        $welcome['slug'] = STR::slug($welcome['title']);
        $welcome['content'] = file_get_contents(base_path().'/README.md');
        Page::create($welcome);
    }
}
