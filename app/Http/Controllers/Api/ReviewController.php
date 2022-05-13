<?php

namespace App\Http\Controllers\Api;

use App\Doctor;
use App\Http\Controllers\Controller;
use App\Mail\NewReview;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{   
    //
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            "doctor_id" => "required|exists:doctors,id",
            "title" => "required|min:2,max:20",
            "author" => "required|min:2",
            "vote" => "required|digits_between:0,5|integer",
            "review" => "required|min:10",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "response" => $validator->errors(),
            ]);
        } else {
            $newReview = new Review();
            $newReview->fill($data);
            $newReview->save();

            $doc = Doctor::where("id", $data["doctor_id"])
                ->with("user")
                ->first();
            $docMail = $doc->user->email;
            $docName = $doc->user->name;
            $docSurname = $doc->user->surname;

            Mail::to($docMail)->send(
                new NewReview($newReview, $docName, $docSurname)
            );

            return response()->json([
                "success" => true,
            ]);
        }
    }

    public function index($docSlug) {

        $doctor = Doctor::all()->where('slug', '=', $docSlug)->first();

        $reviews = Review::all()->where('doctor_id', '=' , $doctor->id)->sortByDesc('created_at')->values()->all();

        return response()->json([
            'results' => $reviews,
            'success' => true,
        ]);       
    }

}
