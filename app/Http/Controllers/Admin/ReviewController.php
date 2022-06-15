<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewReviewResponse;
use App\Review;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    //
    public function index($slug){
        if(Auth::user()->professional->slug == $slug){
            $reviews = Auth::user()->professional->reviews->sortByDesc('created_at');
            return view('Admin.Reviews.index', compact('reviews'));
        } else {
            return redirect()->route('401');
        }
    }

    public function store(Request $request, Review $review){
        $data = $request->all();
        $validator = Validator::make($data, [
            "content" => "required|min:10",
            "title" => "required|min:2,max:20",
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->route('admin.reviews', Auth::user()->professional->slug)->with('fail', 'Impossibile inviare il messaggio')->with(compact('errors'));
        } else {
            $email = $review->email;
            $name= $review->author;
            $date = $review->created_at;
            $docName = Auth::user()->name;
            $docSurname = Auth::user()->surname;
            $content = $data['content'];

            Mail::to($email)->send(new NewReviewResponse($name, $docName, $docSurname,$date,$content));

            return redirect()->route('admin.reviews', Auth::user()->professional->slug)->with('success', 'Messaggio di risposta inviato con successo');
        }
    }
}
