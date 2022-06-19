<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Specialty;

class SpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSpecialties()
    {
        $specialties = Specialty::all();

        return response()->json([
        
            'results' => $specialties,
            'success' => true,
        
        ]);
    }

}
