<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = User::first();
        if($response == null){
            User::create([
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'position' => 'admin',
                'role' => 'ADMIN',
                'branch_id' => 1,
                'remember_token' => 'admin',
                'password' => bcrypt('1234'),

            ]);
            if(env('APP_ENV') === 'local') {
                User::factory()->count(10)->create();
            }
        }
    }
}
