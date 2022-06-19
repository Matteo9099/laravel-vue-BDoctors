<?php

use App\Doctor;
use App\Lead;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
class LeadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $doctors = Doctor::all();
        foreach ($doctors as $doctor){
            for($i = 0; $i < $faker->numberBetween(0, 10); $i++) {
              $newLead = new Lead();
              $newLead->author = $faker->name . $faker->lastName;
              $newLead->email = $faker->email;
              $newLead->message = $faker->sentence;
              $newLead->doctor_id = $doctor->id;
              $newLead->save();
            }
        }
    }
}
