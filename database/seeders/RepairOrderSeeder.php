<?php

namespace Database\Seeders;

use App\Models\RepairOrder;
use Illuminate\Database\Seeder;

class RepairOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = RepairOrder::first();
        if($response == null){
            RepairOrder::factory()->count(500)->create();
        }
    }
}
