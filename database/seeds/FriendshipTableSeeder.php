<?php

use Illuminate\Database\Seeder;

class FriendshipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= App\User::all()->count(); $i++) {
            for ($j = $i + 1; $j <= App\User::all()->count(); $j++) {
                if (rand(0,2)) {
                    DB::table('friendship')->insert([
                        'user_id' => $i,
                        'target_id' => $j,
                        'is_accepted' => rand(0,1) ? true : false,
                    ]);
                }
            }
        }
    }
}
