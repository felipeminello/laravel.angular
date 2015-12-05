<?php

use CodeProject\User;
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
	    User::truncate();

	    factory(User::class)->create();
    }
}
