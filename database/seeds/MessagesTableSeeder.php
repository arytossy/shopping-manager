<?php

use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 30; $i++) {
            DB::table('messages')->insert([
                'content' => 'sample-' . $i,
                'thread_id' => rand(1, App\Thread::all()->count()),
                'said_by' => rand(1, App\User::all()->count()),
            ]);    
        }
    }
}
