<?php

use App\Specialty;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SpecialtyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialties = ['Cardiologia', 'Chirurgia', 'Pediatria', 'Allergologia', 'Reumatologia', 'Psichiatria', 'Medicina del lavoro', 'Gastroenterologia', 'Medicina Subacquea', 'Radiologia', 'Urologia'];

        foreach ($specialties as $specialty) {
            $newSpecialty = new Specialty();
            $newSpecialty->name = $specialty;
            $newSpecialty->slug = Str::slug($specialty);
            $newSpecialty->save();
        }
    }
}
