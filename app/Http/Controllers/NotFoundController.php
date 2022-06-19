<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotFoundController extends Controller
{
    //
    public function index(){
        return view('Errors.404');
    }

    public function unauthorized(){
        return view('Errors.401');
    }
}
