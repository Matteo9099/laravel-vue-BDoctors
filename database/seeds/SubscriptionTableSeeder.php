<?php

use App\Subscription;
use Illuminate\Database\Seeder;

class SubscriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $subscriptions = [
            'bronze' => 2.99,
            'silver' => 5.99,
            'gold' => 9.99,
        ];

        foreach($subscriptions as $key =>$price){
            $newSubscription = new Subscription();
            $newSubscription->price = $price;
            $newSubscription->name = $key;
            $newSubscription->save();
        }
    }
}
