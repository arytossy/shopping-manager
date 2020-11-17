<?php

use Illuminate\Database\Seeder;

class OrderingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= App\Item::all()->count(); $i++) {
            for ($j = 1; $j <= App\User::all()->count(); $j++) {
                if (rand(0,1)) {
                    DB::table('ordering')->insert([
                        'item_id' => $i,
                        'user_id' => $j,
                        'required_number' => rand(1,3),
                    ]);
                }
            }
        }
    }
}
