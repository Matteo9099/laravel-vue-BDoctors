<?php

namespace App\Http\Controllers\Api;

use App\Doctor;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    //
    public function index()
    {
        $doctors = Doctor::with(["user", "specialties"])->paginate(10);

        $doctors->each(function ($doctor) {
            //se ho photo
            if ($doctor->photo) {
                $doctor->photo = url("storage/" . $doctor->photo);
            } else {
                $doctor->photo = url("img/not_found.jpg");
            }

            if ($doctor->cv) {
                $doctor->cv = url("storage/" . $doctor->cv);
            } else {
                $doctor->cv = "Nessun Curriculum presente!";
            }
        });

        return response()->json([
            "results" => $doctors,
            "success" => true,
        ]);
    }

    //singolo dottore
    public function show($slug)
    {
        $doctor = Doctor::where("slug", $slug)
            ->with(["user", "specialties", "reviews"])
            ->first();

        if (!$doctor) {
            return response()->json([
                "results" => "Nessun dottore corrisponde alla ricerca",
                "success" => false,
            ]);
        } else {
            //se ho photo
            if ($doctor->photo) {
                $doctor->photo = url("storage/" . $doctor->photo);
            } else {
                $doctor->photo = url("img/not_found.jpg");
            }

            if ($doctor->cv) {
                $doctor->cv = url("storage/" . $doctor->cv);
            } else {
                $doctor->cv = "Nessun Curriculum presente!";
            }

            return response()->json([
                "results" => $doctor,
                "success" => true,
            ]);
        }
    }

    //funzione provvisoria per ottenere i dottori nella HOME
    public function getAllDoctors($specialtySlug = null)
    {
        $doctors = Doctor::with(["user", "specialties", "leads", "reviews"])->get();

        //immagini in home
        $doctors->each(function ($doctor) use ($doctors) {
            $counter = 0;
            if(count($doctor->subscriptions) > 0){
//                dd($counter);
                $doctors->splice($counter, 0, [$doctor]);
            };
            //se ho photo
            if ($doctor->photo) {
                $doctor->photo = url("storage/" . $doctor->photo);
            } else {
                $doctor->photo = url("img/not_found.jpg");
            }

            if ($doctor->cv) {
                $doctor->cv = url("storage/" . $doctor->cv);
            } else {
                $doctor->cv = "Nessun Curriculum presente!";
            }
        });
//        $doctorsFirst = $doctors;

//        dd($doctors);
        if(!isset($specialtySlug)){
            return response()->json([
                "results" => $doctors->unique(),
                "success" => true,
            ]);
        } else {
            $doctorsBySpecialty = $doctors->filter(function($doctor) use($specialtySlug){
                if($doctor->specialties->contains('slug', $specialtySlug)){
                    return true;
                } else {
                    return false;
                }
            })->values()->all();

            return response()->json([
                "results" => $doctorsBySpecialty,
                "success" => true,
            ]);
        }
    }

    public function doctorByVote($average)
    {
        $doctors = Doctor::with(["reviews", "user", "specialties", "leads"])->get();
        //immagini in home
        $doctors->each(function ($doctor) {
            //se ho photo
            if ($doctor->photo) {
                $doctor->photo = url("storage/" . $doctor->photo);
            } else {
                $doctor->photo = url("img/not_found.jpg");
            }

            if ($doctor->cv) {
                $doctor->cv = url("storage/" . $doctor->cv);
            } else {
                $doctor->cv = "Nessun Curriculum presente!";
            }
        });
        $filterByVote = $doctors->filter(function ($doctor) use ($average) {
            $averageVote = null;
            $sum = 0;
            foreach ($doctor->reviews as $review) {
                $sum += $review->vote;
            }
            if(count($doctor->reviews) == 0){
                $averageVote = $sum;
            }else{
                $averageVote = $sum / count($doctor->reviews);
            }
//            dd($averageVote, intval($average));
            if (
                $averageVote >= intval($average) &&
                $averageVote < intval($average) + 1
            ) {
                return true;
            } else {
                return false;
            }
        })->values()->all();

        if (count($filterByVote) > 0) {
            return response()->json([
                "success" => true,
                "average" => 'Media voto: ' . $average,
                "results" =>$filterByVote,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "results" => "Nessun Medico con questa media voti!",
            ]);
        }
    }
    //per media voti
    public function doctorByAvg($average){
        $doctors = Doctor::with(["reviews","specialties","leads","user"])->get();
        $doctors->each(function ($doctor) {
            //se ho photo
            if ($doctor->photo) {
                $doctor->photo = url("storage/" . $doctor->photo);
            } else {
                $doctor->photo = url("img/not_found.jpg");
            }

            if ($doctor->cv) {
                $doctor->cv = url("storage/" . $doctor->cv);
            } else {
                $doctor->cv = "Nessun Curriculum presente!";
            }
        });
        $filtered = $doctors->filter(function ($doctor) use($average){
            $sum = 0;
            $reviewCounter = 0;
            $averageVote = 0;
            foreach ($doctor->reviews as $review){
                $reviewCounter++;
                $sum += intval($review->vote);
                }
            if($reviewCounter === 0){
                $averageVote = $sum;
            } else {
                $averageVote = $sum/$reviewCounter;
            }

            if($averageVote >= intval($average) && $averageVote < intval($average) + 1){
                return true;
            } else {
                return false;
            }
        })->values()->all();

        if(count($filtered) > 0){
            return response()->json([
                'success' => true,
                'results' => $filtered,
                'message' => 'Ecco tutti i dottori con media voto ' . $average,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'results' => 'Nessun medico con questa media voti',
            ]);
        }
    }
    //per numero di recensioni
    public function doctorByReviewsNumber($rangeMin)
    {
        $doctors = Doctor::with(["reviews", "specialties", "leads", "user"])->get();
        $doctors->each(function ($doctor) {
            //se ho photo
            if ($doctor->photo) {
                $doctor->photo = url("storage/" . $doctor->photo);
            } else {
                $doctor->photo = url("img/not_found.jpg");
            }

            if ($doctor->cv) {
                $doctor->cv = url("storage/" . $doctor->cv);
            } else {
                $doctor->cv = "Nessun Curriculum presente!";
            }
        });
        $filtered = $doctors->filter(function ($doctor) use ($rangeMin) {
            $reviewCounter = 0;
            foreach ($doctor->reviews as $review) {
                $reviewCounter++;
            }

            if (intval($rangeMin) == 10) {
                if ($reviewCounter >= intval($rangeMin)) {
                    return true;
                } else {
                    return false;
                }
            } elseif (intval($rangeMin) == 1){
                $rangeMin = 0;
                if ($reviewCounter >= 0 && $reviewCounter < $rangeMin + 5) {
                    return true;
                } else {
                    return false;
                }
            } else {
                if ($reviewCounter >= intval($rangeMin) && $reviewCounter < intval($rangeMin) + 5) {
                    return true;
                } else {
                    return false;
                }
            }

        })->values()->all();
        if (count($filtered) > 0) {
            return response()->json([
                'success' => true,
                'results' => $filtered,
                'message' => 'Ecco tutti i dottori numero di recensioni compreso tra ' . $rangeMin . ' e ' . ($rangeMin + 5),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'results' => 'Nessun medico con questo numero di recensioni',
            ]);
        }
    }
    // dottori media e n recensioni
    public function doctorByAll($average, $rangeMin){
        $doctors = Doctor::with(["reviews","specialties","leads","user"])->get();
        $doctors->each(function ($doctor) {
            //se ho photo
            if ($doctor->photo) {
                $doctor->photo = url("storage/" . $doctor->photo);
            } else {
                $doctor->photo = url("img/not_found.jpg");
            }

            if ($doctor->cv) {
                $doctor->cv = url("storage/" . $doctor->cv);
            } else {
                $doctor->cv = "Nessun Curriculum presente!";
            }
        });
        $filtered = $doctors->filter(function($doctor) use($average, $rangeMin){
            $reviewCounter = 0;
            $sum = 0;
            $averageVote = 0;
            foreach ($doctor->reviews as $review){
                $reviewCounter++;
                $sum += intval($review->vote);
            }
            if($reviewCounter === 0){
                $averageVote = $sum;
            } else {
                $averageVote = $sum/$reviewCounter;
            }

            if($rangeMin == 10){
                if($reviewCounter >= $rangeMin && $averageVote >= intval($average) && $averageVote < intval($average) + 1){
                    return true;
                } else {
                    return false;
                }
            } else {
                if($reviewCounter >= $rangeMin && $reviewCounter < ($rangeMin + 5) && $averageVote >= intval($average) && $averageVote < intval($average) + 1){
                    return true;
                } else {
                    return false;
                }
            }
        })->values()->all();
        if(count($filtered) > 0){
            return response()->json([
                'success' => true,
                'results' => $filtered,
                'message' => 'Ecco tutti i dottori numero di recensioni compreso tra ' . $rangeMin . ' e ' . ($rangeMin + 5) . ' e  media voto di ' . $average,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'results' => 'Nessun medico con questo numero di recensioni  media voto',
            ]);
        }
    }
    //filter
    public function filter(Request $request){

        $avg = $request->query('average');
//        dd($avg);
        $rMin = $request->query('rangeMin');
//        $rMax = $request->query('rangeMax');
        if(isset($avg) && !isset($rMin)){
            return $this->doctorByAvg($avg);
        } elseif (!isset($avg) && isset($rMin)){
            return $this->doctorByReviewsNumber($rMin);
        } else {
            return $this->doctorByAll($avg, $rMin);
        }
//        return $this->doctorByReviewsNumber($rMin, $rMax);

    }
//$average = null, $rangeMin = null, $rangeMax = null
    public function doctorsSponsored(){
        $doctors = Doctor::with(['user', 'subscriptions', 'specialties', 'reviews'])->get();
        $doctors->each(function ($doctor) {
            //se ho photo
            if ($doctor->photo) {
                $doctor->photo = url("storage/" . $doctor->photo);
            } else {
                $doctor->photo = url("img/not_found.jpg");
            }

            if ($doctor->cv) {
                $doctor->cv = url("storage/" . $doctor->cv);
            } else {
                $doctor->cv = "Nessun Curriculum presente!";
            }
        });
        $filtered = $doctors->filter(function($doctor){
           $sponsorFilter = $doctor->subscriptions->filter(function($sub){
               $dateOne = new Carbon($sub->pivot->expires_at);
               $dateTwo = Carbon::now()->format('M d Y');
               if($dateOne->gt($dateTwo)){
                   return true;
               } else{
                   return false;
               }
           })->values()->all();
//           dd($sponsorFilter);
           if(count($sponsorFilter) > 0){
               return true;
           } else{
               return false;
           }
        })->values()->all();

        if($filtered){
            return response()->json([
                'success' => true,
                'results' => $filtered,
            ]);
        } else{
            return response()->json([
                'success'=> false,
                'results' => 'Nessun dottore sponsorizzato!'
            ]);
        }
    }
}
