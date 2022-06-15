<?php

namespace App\Http\Controllers\Api;

use App\Professional;
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
            "professional_id" => "required|exists:professionals,id",
            "title" => "required|min:2,max:20",
            "author" => "required|min:2",
            "email" => "required|email",
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

            $doc = Professional::where("id", $data["professional_id"])
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

        $professional = Professional::all()->where('slug', '=', $docSlug)->first();

        $reviews = Review::all()->where('professional_id', '=' , $professional->id)->sortByDesc('created_at')->values()->all();

        return response()->json([
            'results' => $reviews,
            'success' => true,
        ]);
    }

}
