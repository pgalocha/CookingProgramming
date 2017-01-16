<?php

use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            'email' => 'mary@mail.com',
            'text' => 'Very Nice!',
            'active'=> true,
            'post_id' => 1

        ]);

        DB::table('comments')->insert([
            'email' => 'mordor@mail.com',
            'text' => 'so dark',
            'active'=> true,
            'post_id' => 1

        ]);
    }
}
