<?php

namespace App\Http\Controllers\Admin;

use App\Doctor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    //
    public function photoDelete($slug){

        $doctor = Doctor::where('slug', $slug)->first();

        Storage::delete( $doctor->photo);

        $doctor->photo =  null;

        $doctor->save();

        return redirect()->route('admin.doctors.edit', $doctor->slug);

    }
}
