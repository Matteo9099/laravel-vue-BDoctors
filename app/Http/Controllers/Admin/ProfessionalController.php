<?php

namespace App\Http\Controllers\Admin;

use App\Professional;
use App\Http\Controllers\Controller;
use App\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Comparator\Comparator;
use Illuminate\Support\Str;

class ProfessionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // recupero specializzazioni
        $specialties = Specialty::all();
        $professional = Auth::user()->professional;

        if(!Auth::user()->professional){
            return view('Admin.professionals.create', compact('specialties'));
        } else{
            return redirect()->route('admin.home', compact('professional'))->with('alreadyCreated', 'Hai già creato il tuo profilo!');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Professional $professional)
    {
        //
        $request->validate(
            [
                'medical_address' => 'nullable|min:2',
                'performance' => 'nullable|min:10',
                'phone' => 'nullable|min:2|numeric',
                'photo' => 'nullable|mimes:png,jpg,jpeg|max:4096',
                'specialtiesId' => 'nullable|exists:specialties,id',
                'otherSpec' => 'nullable|string|min:3|max:12',
            ]
        );

        $data = $request->all();

        $slug  = Str::slug(Auth::user()->name . "-" . Auth::user()->surname );

        // slug unico
        $counter = 1;

        while (Professional::where('slug', $slug)->first()) {
            // se è già presente aggiunge il counter allo slug creato
            $slug  = Str::slug(Auth::user()->name . "-" . Auth::user()->surname) . '-' . $counter;
            $counter++;
        };

        $data['slug'] = $slug;

        if(!isset($data['specialtiesId'])){
            $data['specialtiesId'] = "Nessuna specializzazione selezionata!";
            return redirect()->route('admin.professionals.create');
        }

        if(isset($data['photo'])){
            $imageUrl = Storage::put('doc_img', $data['photo']);
            $data['photo'] = $imageUrl;
        }

        $data['user_id'] = Auth::user()->id;

        // dd($data);

        $professional->fill($data);
        $professional->save();

        if (isset($data['specialtiesId']) || isset($data['otherSpec'])) {
            // se è incluso altro
            if ($data['otherSpec']) {

                // dd($data['otherSpec']);
                $slug = Str::slug($data['otherSpec']);
                $checkSpec = Specialty::where('slug', $slug)->first();

                if ($checkSpec) {

                    if (isset($data['specialtiesId']) && is_numeric($data['specialtiesId']) ) {
                        array_push($data['specialtiesId'], strval($checkSpec->id));
                        $professional->specialties()->sync($data['specialtiesId']);
                    } else {
                        $professional->specialties()->sync($checkSpec->id);
                    }
                } else {
                    $specialty = Specialty::create(
                        [
                            'name' => ucfirst($data['otherSpec']),
                            'slug' => $slug,
                        ]
                    );

                    if (isset($data['specialtiesId']) && is_numeric($data['specialtiesId'])) {
                        array_push($data['specialtiesId'], strval($specialty->id));
                        $professional->specialties()->sync($data['specialtiesId']);
                    } else {
                        $professional->specialties()->sync($specialty->id);
                    }
                }
            } else {
                $professional->specialties()->sync($data['specialtiesId']);
            }
        }

        return redirect()->route('admin.home')->with('status', 'Profilo creato con successo!');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show($slug)
    {
        $professional = Professional::where('slug', $slug)->first();
        return view('Admin.professionals.show', compact('professional'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        if(is_numeric($slug)){
            return redirect()->route('404');
        }
        // dd($professional->id);
        $specialties = Specialty::all();
        $professional = Professional::where('slug', $slug)->first();
        // dd($professional);
        if(Auth::user()->professional && Auth::user()->professional->id == $professional->id){
            return view('Admin.professionals.edit', compact('professional', 'specialties'));
            // return view('Admin.professionals.edit', compact('professional', 'specialties'));
        } else {
            return redirect()->route('401');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Professional $professional)
    {
        //
        $request->validate(
            [
                'medical_address' => 'nullable|min:2',
                'performance' => 'nullable|min:10',
                'phone' => 'nullable|min:2|numeric',
                'photo' => 'nullable|mimes:png,jpg,jpeg|max:4096',
                'specialtiesId' => 'nullable|exists:specialties,id',
                'otherSpec' => 'nullable|string|min:3|max:12',
            ]
        );

        $data = $request->all();

        $slug  = Str::slug(Auth::user()->name . "-" . Auth::user()->surname);

        if(professional::where('slug', $slug)->first()){
            $counter = 1;
            while (Professional::where('slug', $slug)->first()) {
                // se è già presente aggiunge il counter allo slug creato
                $slug  = Str::slug(Auth::user()->name . "-" . Auth::user()->surname) . '-' . $counter;
                $counter++;
            };
        }

        $data['slug'] = $slug;

        if (!isset($data['specialtiesId']) && !isset($data['otherSpec'])) {
            $data['specialtiesId'] = "Nessuna specializzazione selezionata!";
            return redirect()->route('admin.professionals.edit', compact('professional'));
        }

        if (isset($data['photo'])) {
            //ma voglio anche rimuovere l'immagine vecchia se presente
            if ($professional->photo) {
                Storage::delete($professional->photo);
            }

            $imageUrl = Storage::put('doc_img', $data['photo']);
            $data['photo'] = $imageUrl;

        }

        // dd($data);
        $professional->update($data);
        $professional->save();

        if (isset($data['specialtiesId']) || isset($data['otherSpec'])) {
            // se è incluso altro
            if ($data['otherSpec']) {

                // dd($data['otherSpec']);
                $slug = Str::slug($data['otherSpec']);
                $checkSpec = Specialty::where('slug', $slug)->first();

                if ($checkSpec) {

                    if (isset($data['specialtiesId'])) {
                        array_push($data['specialtiesId'], strval($checkSpec->id));
                        $professional->specialties()->sync($data['specialtiesId']);
                    } else {
                        $professional->specialties()->sync($checkSpec->id);
                    }

                } else {
                    $specialty = Specialty::create(
                        [
                            'name' => ucfirst($data['otherSpec']),
                            'slug' => $slug,
                        ]
                    );

                    if(isset($data['specialtiesId'])){
                        array_push($data['specialtiesId'], strval($specialty->id));
                        $professional->specialties()->sync($data['specialtiesId']);
                    } else {
                        $professional->specialties()->sync($specialty->id);
                    }
                }

            } else {
                $professional->specialties()->sync($data['specialtiesId']);
            }
        }

        return redirect()->route('admin.home')->with('status', 'Profilo aggiornato con successo!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Professional $professional)
    {
        //
        $specialties = Specialty::all();
        $professional->specialties->each(function($specialty){
//            dd($specialty);
            if($specialty->id > 11 && count($specialty->professionals) == 1){
                $specialty->delete();
            }
        });

        $specialties->each(function($specialty){
//            dd($specialty);
            if($specialty->id > 11 && count($specialty->professionals) == 1){
                $specialty->delete();
            }
        });

        if($professional->photo){
            Storage::delete($professional->photo);
        }

        $professional->delete();

        return redirect()->route('admin.home')->with('alreadyCreated', 'Profilo eliminato con successo!');
    }

    public function charts($slug){
        if(Auth::user()->professional->slug == $slug){
            // logiche per numero recensioni per voto
            $reviews = Auth::user()->professional->reviews;
            $leads = Auth::user()->professional->leads->sortBy('created_at');
            $count = count($reviews);
            $sum = 0;
            $totalAverage = 0;
            $averageZero = [];
            $averageOne = [];
            $averageTwo = [];
            $averageThree = [];
            $averageFour = [];
            $averageFive = [];
            foreach ($reviews as $review){
                $sum += intval($review->vote);
//                $totalAverage = $sum / $count;
                if($review->vote == 0){
                    $averageZero[] = $review->vote;
                } elseif($review->vote == 1){
                    $averageOne[] = $review->vote;
                } elseif ($review->vote == 2){
                    $averageTwo[] = $review->vote;
                } elseif ($review->vote == 3){
                    $averageThree[] = $review->vote;
                } elseif ($review->vote == 4){
                    $averageFour[] = $review->vote;
                } else {
                    $averageFive[] = $review->vote;
                }
            }
            if($count > 0){
                $totalAverage = $sum / $count;
            }
            $chartReviews = [
                count($averageZero),
                count($averageOne),
                count($averageTwo),
                count($averageThree),
                count($averageFour),
                count($averageFive),
            ];
            // logiche per recensioni ricevute ogni mese
            $countLeads = count($leads);
            $leadsByMonth = [

            ];
            $genCount = 1;
            $febCount = 1;
            $marCount = 1;
            $aprCount = 1;
            $mayCount = 1;
            $junCount = 1;
            $julCount = 1;
            $agoCount = 1;
            $sepCount = 1;
            $ottCount = 1;
            $novCount = 1;
            $decCount = 1;

            $counter = 1;
            foreach ($leads as $lead){
                $date = new Carbon($lead->created_at);
                $month = $date->format('M');
                if($month == 'Gen'){
                    $leadsByMonth[$month] = $genCount++;
                } elseif($month == 'Feb'){
                    $leadsByMonth[$month] = $febCount++;
                } elseif($month == 'Mar') {
                    $leadsByMonth[$month] = $marCount++;
                }  elseif($month == 'Apr') {
                    $leadsByMonth[$month] = $aprCount++;
                }  elseif($month == 'May') {
                    $leadsByMonth[$month] = $mayCount++;
                }  elseif($month == 'Jun') {
                    $leadsByMonth[$month] = $junCount++;
                }  elseif($month == 'Jul') {
                    $leadsByMonth[$month] = $julCount++;
                }  elseif($month == 'Aug') {
                    $leadsByMonth[$month] = $agoCount++;
                }  elseif($month == 'Sep') {
                    $leadsByMonth[$month] = $sepCount++;
                }  elseif($month == 'Oct') {
                    $leadsByMonth[$month] = $ottCount++;
                }  elseif($month == 'Nov') {
                    $leadsByMonth[$month] = $novCount++;
                }  else {
                    $leadsByMonth[$month] = $decCount++;
                }
            }

            return view('Admin.professionals.charts', compact('chartReviews', 'totalAverage', 'leadsByMonth', 'countLeads'));
        } else {
            return view('Errors.401');
        }
    }
}
