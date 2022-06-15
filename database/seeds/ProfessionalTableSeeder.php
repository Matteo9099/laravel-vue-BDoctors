<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Professional;
use App\User;
use App\Specialty;
use Illuminate\Support\Str;

class ProfessionalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $specialties = Specialty::all();
        $specialtyId = [];
        foreach ($specialties as $specialty){
            $specialtyId[] = intval($specialty->id);
        }
        $specialtyPlaceHolder = [];
        for($i = 0; $i <= $faker->numberBetween(1,4); $i++) {
            $specialtyPlaceHolder[] = (intval(floor(count($specialtyId) / $faker->randomDigitNotNull())));
        }
        for($i = 1; $i <= 30; $i++) {
          $newUser = new User();
          $newUser->name = $faker->unique()->firstName;
          $newUser->surname = $faker->unique()->lastName;
          $newUser->email = $faker->unique()->email;
          $newUser->address = $faker->address;
          $newUser->password = Hash::make($faker->numerify('user-####'));
          $newUser->save();
          $newprofessional = new Professional();
          $newprofessional->phone = $faker->phoneNumber;
          $newprofessional->medical_address = $faker->address;
          $newprofessional->photo = 'professional-login.png';
          $newprofessional->performance = $faker->paragraph;
          $newprofessional->slug = $faker->unique()->lexify('slug-????');
          $newprofessional->user_id = $newUser->id;
          $newprofessional->save();
          $newprofessional->slug = Str::slug($newprofessional->user['name'] .'-'. $newprofessional->user['surname']);
          $newprofessional->save();
          $newprofessional->specialties()->sync($specialtyPlaceHolder);
          $specialtyPlaceHolder = [];
          $specialtyPlaceHolder[] = $faker->randomElement($specialtyId, 3);
          $boolPlaceholder = null;
          if($boolPlaceholder == $faker->boolean){
              $specialtyPlaceHolder[] = $faker->randomElement($specialtyId, 6);
          }
          if($boolPlaceholder == $faker->boolean){
              $specialtyPlaceHolder[] = $faker->randomElement($specialtyId, 1);
          }
          if($boolPlaceholder == $faker->boolean){
              $specialtyPlaceHolder[] = $faker->randomElement($specialtyId, 5);
          }

        }
    }
}
