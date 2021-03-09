<?php

use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            'name' => 'Chevrolet',
            'picture_uri' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('brands')->insert([
            'name' => 'Jeep',
            'picture_uri' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
