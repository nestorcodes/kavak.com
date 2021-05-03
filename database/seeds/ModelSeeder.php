<?php

use Illuminate\Database\Seeder;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //chevrolet
        DB::table('car_models')->insert([
            'name' => 'Equinox LTZ',
	        'brand_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('car_models')->insert([
            'name' => 'Aveo LS',
	        'brand_id' => 1,'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('car_models')->insert([
            'name' => 'Spark Hatch Back LTZ',
	        'brand_id' => 1,'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('car_models')->insert([
            'name' => 'Cruze LS Turbo',
	        'brand_id' => 1,'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('car_models')->insert([
            'name' => 'Cavalier LS',
	        'brand_id' => 1,'created_at' => now(),
            'updated_at' => now()
        ]);

        //Jeep
        DB::table('car_models')->insert([
            'name' => 'Cherokee Limited',
	        'brand_id' => 2,'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('car_models')->insert([
            'name' => 'Renegade Latitude',
	        'brand_id' => 2,'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('car_models')->insert([
            'name' => 'Compass Limited Premium',
	    'brand_id' => 2,'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('car_models')->insert([
            'name' => 'Patriot Sport',
	    'brand_id' => 2,'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('car_models')->insert([
            'name' => 'Wrangler Unlimited Sahara',
	    'brand_id' => 2,'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
