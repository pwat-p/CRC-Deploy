<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BranchSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(CarModelSeeder::class);
        if(env('APP_ENV') === 'local') {
            $this->call(CustomerSeeder::class);
            $this->call(RepairOrderSeeder::class);
        }
    }
}
