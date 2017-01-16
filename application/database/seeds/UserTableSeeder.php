<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
           'name'=>'Joe',
            'email'=>'joe@gmail.com',
            'password'=> bcrypt('secret'),
            'contact'=> '968325138',
            'avatar'=> 'default.jpg',
        ]);
        DB::table('users')->insert([
            'name'=>'mike',
            'email'=>'mike@gmail.com',
            'password'=> bcrypt('secret2'),
            'contact'=> '968325137',
            'avatar'=> 'default.jpg',
        ]);
    }
}
