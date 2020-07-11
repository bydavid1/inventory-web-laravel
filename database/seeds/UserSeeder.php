<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role_user;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('admin123');
        $user->save();
    }
}
