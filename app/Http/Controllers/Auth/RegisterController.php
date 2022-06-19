<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Doctor;
use App\Specialty;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'specialty_id' => ['required', 'min:0'], //specializzazioni
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'otherSpec' => ['nullable', 'string', 'min:3'],

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function create(array $data)
    {
        if($data['specialty_id'] == 'select' && !$data['otherSpec']){
            $data['specialty_id'] = 1;
        }

        $user = User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'address' => $data['address'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);



        // dd($data['specialty_id']);
        $slug  = Str::slug($data['name'] .'-'. $data['surname']);

        // slug unico
        $counter = 1;

        while (Doctor::where('slug', $slug)->first()) {
            // se è già presente aggiunge il counter allo slug creato
            $slug  = Str::slug($data['name'] .'-'. $data['surname']) . '-' . $counter;
            $counter++;
        };


        $doctor = Doctor::create([
            'user_id' => $user->id,
            'slug' => $slug,
        ]);



        if($data['specialty_id'] == 'select'){

            if(!$data['otherSpec']){
                return redirect()->route('guests.home');
            } else {

                $slug = Str::slug($data['otherSpec']);
                $checkSpec = Specialty::where('slug', $slug)->first();
                if($checkSpec){

                    $doctor->specialties()->sync($checkSpec->id);
                } else{

                    $specialty = Specialty::create(
                        [
                            'name' => ucfirst($data['otherSpec']),
                            'slug' => Str::slug($data['otherSpec']),
                        ]
                    );
                    $doctor->specialties()->sync($specialty->id);
                }
            }


        } else {
            $doctor->specialties()->sync($data['specialty_id']);
        }


        return $user;

    }

}
