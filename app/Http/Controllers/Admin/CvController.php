<?php

namespace App\Http\Controllers\Admin;

use App\Doctor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CvController extends Controller
{
    //
    public function getCv(){

        $cvRef = Auth::user()->doctor->cv;
        return Storage::download($cvRef, Auth::user()->name . Auth::user()->surname . 'CV' . '.pdf');
    }

    public function cvDelete($slug)
    {

        $doctor = Doctor::where('slug', $slug)->first();

        Storage::delete($doctor->cv);

        $doctor->cv =  null;

        $doctor->save();
        // dd($doctor);
        return redirect()->route('admin.doctors.edit', $doctor->slug);
    }
}
