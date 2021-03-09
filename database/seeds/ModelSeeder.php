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
        DB::table('models')->insert([
            'name' => 'Chevrolet Equinox LTZ',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('models')->insert([
            'name' => 'Chevrolet Aveo LS',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('models')->insert([
            'name' => 'Chevrolet Spark Hatch Back LTZ',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('models')->insert([
            'name' => 'Chevrolet Cruze LS Turbo',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('models')->insert([
            'name' => 'Chevrolet Cavalier LS',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        ///////////////////////////////////////////
        //Jeep
        DB::table('models')->insert([
            'name' => 'Jeep Cherokee Limited',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('models')->insert([
            'name' => 'Jeep Renegade Latitude',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('models')->insert([
            'name' => 'Jeep Compass Limited Premium',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('models')->insert([
            'name' => 'Jeep Patriot Sport',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('models')->insert([
            'name' => 'Jeep Wrangler Unlimited Sahara',
            'created_at' => now(),
            'updated_at' => now()
        ]);


        
    }
}
