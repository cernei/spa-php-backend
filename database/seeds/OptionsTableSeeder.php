<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('options')->insert([
            'name' => 'Pastry',
            'description' => 'Pastry thickness',
            'type' => 1,
            'values' => json_encode(['Thin', 'Thick']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}
