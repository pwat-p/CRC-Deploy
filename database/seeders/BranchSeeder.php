<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Branch::first();
        if($response == null){
            Branch::create([
                'name' => 'ADMIN',
            ]);

            if(env('APP_ENV') === 'local') {
                Branch::factory()->count(3)->create();
            }
        }
    }
}
