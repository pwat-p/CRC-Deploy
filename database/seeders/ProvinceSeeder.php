<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $province = Province::first();
        if($province == null){
            $jsonString = file_get_contents(storage_path('app/init/province.json'));

            //remove ZWNBSP Character
            $jsonString = preg_replace( '/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $jsonString );

            $data = json_decode($jsonString, true);
            foreach ($data as $item){
                $province = new Province();
                $province->name_th = $item['name_th'];
                $province->name_en = $item['name_en'];
                $province->save();
            }
        }
    }
}
