<?php

use Illuminate\Database\Seeder;

class ThreadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            DB::table('threads')->insert([
                'title' => 'sample-' . $i,
                'where_go' => $i % 2 == 0 ? 'shop-' . $i : null,
                'when_go' => $i % 2 == 1 ? date('Y-m-d H:i:s') : null,
            ]);    
        }
    }
}
