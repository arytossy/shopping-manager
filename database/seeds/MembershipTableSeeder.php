<?php

use Illuminate\Database\Seeder;

class MembershipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= App\Thread::all()->count(); $i++) {
            for ($j = 1; $j <= App\User::all()->count(); $j++) {
                if (rand(0,3)) {
                    DB::table('membership')->insert([
                        'thread_id' => $i,
                        'user_id' => $j,
                    ]);
                }
            }
        }
    }
}
