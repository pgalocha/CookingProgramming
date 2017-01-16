<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'title'=> "My first Post",
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipi\
            scing elit, sed do eiusdmo tempor incididunt',
            'user_id'=>1
        ]);

        DB::table('posts')->insert([
            'title'=> "HelloWorld",
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipi\
            scing elit, sed do eiusdmo tempor incididunt',
            'user_id'=>2
        ]);
    }
}
