<?php

namespace App\Console\Commands;

use App\Models\Car;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\Model;
use Illuminate\Console\Command;

class CarDeliver extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'car:deliver';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deliver the car to the customer.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cars = Car::select('id', 'title')->get();
        $this->line($cars);
        $car_value = $this->ask('Select Id?');
        $car = Car::find($car_value);
        if (!$car) {
            $this->error('Car does not exist.');
            return;
        }

        $models = Model::select('id', 'title')->where('car_id', $car->id)->get();
        $this->line($models);
        $model_id = $this->ask('select Id?');
        $model = $car->models()->find($model_id);
        if (!$model) {
            $this->error('The model does not exist for selected Car.');
            return;
        }

        $customers = Customer::select('id', 'name')->get();
        $this->line($customers);

        $id = $this->ask('Select Id?');
        $customer = Customer::find($id);

        if (!$customer) {
            $this->error('Customer does not exist.');
            return;
        }

        $delivery = new Delivery();
        
        $delivery->customer_id = $customer->id;
        $delivery->model_id = $model->id;
        $delivery->car_id = $car->id;
        $delivery->save();

       

        $this->line('Car delivered successfully.');
    }
}
