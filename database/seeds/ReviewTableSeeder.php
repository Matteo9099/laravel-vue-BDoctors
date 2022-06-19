<?php

use App\Doctor;
use App\Review;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class ReviewTableSeeder extends Seeder
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
            for($i = 0; $i < $faker->numberBetween(0, 15); $i++) {
                $newReview = new Review();
                $newReview->author = $faker->name . $faker->lastName;
                $newReview->title = $faker->sentence;
                $newReview->vote = $faker->numberBetween(0,5);
                $newReview->review = $faker->paragraph;
                $newReview->doctor_id = $doctor->id;
                $newReview->email = $faker->email;
                $newReview->save();
            }
        }
    }
}
