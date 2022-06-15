<?php

namespace App\Http\Controllers\Api;

use App\Professional;
use App\Http\Controllers\Controller;
use App\Lead;
use App\Mail\NewLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    //
    public function store(Request $request){

        $data = $request->all();

        $validator = Validator::make(
            $data,
            [
                'author' => 'required|min:2',
                'email' => "required|email",
                'message' => 'required|min:5',
                'professional_id' => 'required|exists:professionals,id',
            ]
        );

        if($validator->fails()){

            return response()->json(
                [
                    'success' => false,
                    'errors' => $validator->errors(),
                ]
            );
        } else {

            $newLead = new Lead();
            $newLead->fill($data);
            $newLead->save();

            $doc = Professional::where('id', $data['professional_id'])->with('user')->first();
            $docMail = $doc->user->email;
            $docName = $doc->user->name;
            $docSurname = $doc->user->surname;

            // dd($newLead);
            Mail::to($docMail)->send(new NewLead($newLead, $docName, $docSurname));

            return response()->json(
                ['success' => true,]
            );
        }

    }
}
