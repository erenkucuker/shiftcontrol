<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'employee']);
        $user = User::create(['name' => 'Example User', 'email' => 'example@gmail.com', 'password' =>  Hash::make('password123')]);
        $user->job()->create(['name' => 'Barista', 'description' => 'Barista Job Description']);
        $user->assignRole('employee');
    }
}
