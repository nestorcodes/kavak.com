<?php

use Illuminate\Database\Seeder;

use App\Models\Car as CarModel;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $data = [
	    	[
			'status_id' => 1,
			'model_id'  => 1,
			'creator_id' => 1,
			'price' => 100000.00,
		],
	    	[
			'status_id' => 1,
			'model_id'  => 2,
			'creator_id' => 1,
			'price' => 200000.00,
		],
	    	[
			'status_id' => 1,
			'model_id'  => 3,
			'creator_id' => 1,
			'price' => 300000.00
		],
	    ];

	    CarModel::insert($data);
    }
}
