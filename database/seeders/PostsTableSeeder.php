<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Teh Manis',
            'price' => 10000,
            'image_link' => '/upload/images/a.jpg',
            'description' => 'Teh yang rasanya manis',
            'category_id' => 2,
            'status' => 'public'
        ]);
    }
}
