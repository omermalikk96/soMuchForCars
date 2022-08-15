<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Model;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this
            ->getSeedData('cars', 'json')
            ->each(function ($car) {
                $models = $car['models'] ?? [];
                unset($car['models']);
                $car = Car::query()->firstOrCreate($car);
                $car_id = $car->id;

                foreach ($models as $model) {
                    $model['car_id'] = $car_id;
                    Model::firstOrCreate($model);
                }
            });
    }
}
