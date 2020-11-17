<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            ThreadsTableSeeder::class,
            ItemsTableSeeder::class,
            MessagesTableSeeder::class,
            
            MembershipTableSeeder::class,
            OrderingTableSeeder::class,
            FriendshipTableSeeder::class,
        ]);
    }
}
