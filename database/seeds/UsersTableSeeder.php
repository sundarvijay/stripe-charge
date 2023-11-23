<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => 1,
            'name' => 'Sundaramoorthi',
            'email' => 'sundarwamp@gmail.com',
            'password' => '123'
        ]);
    }
}
