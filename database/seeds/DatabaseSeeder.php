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
        // $this->call(UserSeeder::class);
        $this->call(SpecialtyTableSeeder::class);
        $this->call(SubscriptionTableSeeder::class);
        $this->call(DoctorTableSeeder::class);
        $this->call(LeadTableSeeder::class);
        $this->call(ReviewTableSeeder::class);
    }
}
