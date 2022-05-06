<?php

namespace App\Http\Controllers\Admin;

use App\Doctor;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index(){

        $doctor = Doctor::where('user_id', Auth::user()->id)->first();

        $user = Auth::user();

        return view ('admin.home', compact('doctor', 'user'));
    }

    public function destroy(User $user){

        $user->delete();
        return redirect()->route('register')->with('deletedUser', 'Utente cancellato con successo');
    }

}
