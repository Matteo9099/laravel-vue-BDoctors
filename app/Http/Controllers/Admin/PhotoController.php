<?php

namespace App\Http\Controllers\Admin;

use App\professional;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    //
    public function photoDelete($slug){

        $professional = Professional::where('slug', $slug)->first();

        Storage::delete( $professional->photo);

        $professional->photo =  null;

        $professional->save();

        return redirect()->route('admin.professionals.edit', $professional->slug);

    }
}
