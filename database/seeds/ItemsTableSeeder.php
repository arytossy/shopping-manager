<?php

use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 25; $i++) {
            DB::table('items')->insert([
                'name' => 'sample-' . $i,
                'is_shared' => rand(0,1) ? true : false,
                'bought_number' => 0,
                'thread_id' => rand(1, App\Thread::all()->count()),
            ]);    
        }
    }
}
