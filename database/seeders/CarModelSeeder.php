<?php

namespace Database\Seeders;

use App\Models\CarModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CarModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = CarModel::first();
        if($response == null){
            $images = Storage::disk('public')->allFiles("model_image");
            foreach ($images as $image) {
                $filename = substr($image, 12);
                $modelName = str_replace("_", " ", substr($filename, 0,strrpos($filename, '.')));
                $path = "/storage/model_image/{$filename}";

                $carmodel = CarModel::create([
                    'name' => $modelName,
                    'model_image' => $path,
                ]);
            }

            $response = CarModel::first();
            if($response == null && env('APP_ENV') === 'local') {
                CarModel::factory()->count(5)->create();
            }
        }
    }
}
