<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Province;
use App\Models\User;
use App\Models\Color;
use App\Models\CarModel;
use Carbon\Traits\Date;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepairOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::get()->random();
        $provinces = Province::pluck('name_th');
        $customers = Customer::get();
        $color = Color::get()->random();
        $model = CarModel::get()->random();

        $list = [
            'FAP23' => null,
            'ใส้กรองอากาศ' => '17220-P2f-505',
            'ลูกสูบเบรค' => ''
        ];
        $orderStatus = array($this->faker->dateTime('now', 'Asia/Bangkok'));
        for ($i=0;$i<5;$i++) {
            if (isset($orderStatus[$i])) {
                array_push($orderStatus,$this->faker->randomElement([$this->faker->dateTime('now', 'Asia/Bangkok'), null]));
            } else {
                array_push($orderStatus,null);
            }
        }
        if (isset($orderStatus[5])) {
            array_push($orderStatus,$this->faker->randomFloat(2, 10000, 20000));
        } else {
            array_push($orderStatus,0);
        }

        return [
            'car_registration' => $this->faker->regexify('[A-Z]{2}[0-9]{4}'),
            'province' => $this->faker->randomElement($provinces),
            'image_path' => NULL,
            'color' => $color->name,
            'model' => $model->name,
            'vin' => $this->faker->regexify('[A-Z0-9]{17}'),
            'current_distance' => $this->faker->randomFloat(3, 0, NULL),
            'latest_distance' => $this->faker->randomFloat(3, 0, NULL),
            'car_received' => $orderStatus[0],
            'in_queued' => $orderStatus[1],
            'repairing' => $orderStatus[2],
            'last_check' => $orderStatus[3],
            'cleaning' => $orderStatus[4],
            'returning' => $orderStatus[5],
            'cost' => $orderStatus[6],

            'repair_list' => json_decode(json_encode($list,true)),

            'user_id' => $users->id,
            'customer_id' => $this->faker->randomElement($customers)->id,
            'branch_id' => $users->branch_id,

            'created_at' => $this->faker->dateTimeBetween('-20 days', now()),
        ];
    }
}
