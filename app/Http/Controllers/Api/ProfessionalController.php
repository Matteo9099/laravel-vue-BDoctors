<?php

namespace App\Http\Controllers\Api;

use App\Professional;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessionalController extends Controller
{
    //
    public function index()
    {
        $professionals = Professional::with(["user", "specialties"])->paginate(10);

        $professionals->each(function ($professional) {
            //se ho photo
            if ($professional->photo) {
                $professional->photo = url("storage/" . $professional->photo);
            } else {
                $professional->photo = url("img/not_found.jpg");
            }
        });

        return response()->json([
            "results" => $professionals,
            "success" => true,
        ]);
    }

    //singolo dottore
    public function show($slug)
    {
        $professional = Professional::where("slug", $slug)
            ->with(["user", "specialties", "reviews"])
            ->first();

        if (!$professional) {
            return response()->json([
                "results" => "Nessun dottore corrisponde alla ricerca",
                "success" => false,
            ]);
        } else {
            //se ho photo
            if ($professional->photo) {
                $professional->photo = url("storage/" . $professional->photo);
            } else {
                $professional->photo = url("img/not_found.jpg");
            }

            return response()->json([
                "results" => $professional,
                "success" => true,
            ]);
        }
    }

    //funzione provvisoria per ottenere i dottori nella HOME
    public function getAllprofessionals($specialtySlug = null)
    {
        $professionals = Professional::with(["user", "specialties", "leads", "reviews"])->get();

        //immagini in home
        $professionals->each(function ($professional) use ($professionals) {
            $counter = 0;
            if(count($professional->subscriptions) > 0){
//                dd($counter);
                $professionals->splice($counter, 0, [$professional]);
            };
            //se ho photo
            if ($professional->photo) {
                $professional->photo = url("storage/" . $professional->photo);
            } else {
                $professional->photo = url("img/not_found.jpg");
            }

        });
//        $professionalsFirst = $professionals;

//        dd($professionals);
        if(!isset($specialtySlug)){
            return response()->json([
                "results" => $professionals->unique(),
                "success" => true,
            ]);
        } else {
            $professionalsBySpecialty = $professionals->filter(function($professional) use($specialtySlug){
                if($professional->specialties->contains('slug', $specialtySlug)){
                    return true;
                } else {
                    return false;
                }
            })->values()->all();

            return response()->json([
                "results" => $professionalsBySpecialty,
                "success" => true,
            ]);
        }
    }

    public function professionalByVote($average)
    {
        $professionals = Professional::with(["reviews", "user", "specialties", "leads"])->get();
        //immagini in home
        $professionals->each(function ($professional) {
            //se ho photo
            if ($professional->photo) {
                $professional->photo = url("storage/" . $professional->photo);
            } else {
                $professional->photo = url("img/not_found.jpg");
            }

        });
        $filterByVote = $professionals->filter(function ($professional) use ($average) {
            $averageVote = null;
            $sum = 0;
            foreach ($professional->reviews as $review) {
                $sum += $review->vote;
            }
            if(count($professional->reviews) == 0){
                $averageVote = $sum;
            }else{
                $averageVote = $sum / count($professional->reviews);
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
    public function professionalByAvg($average){
        $professionals = Professional::with(["reviews","specialties","leads","user"])->get();
        $professionals->each(function ($professional) {
            //se ho photo
            if ($professional->photo) {
                $professional->photo = url("storage/" . $professional->photo);
            } else {
                $professional->photo = url("img/not_found.jpg");
            }

        });
        $filtered = $professionals->filter(function ($professional) use($average){
            $sum = 0;
            $reviewCounter = 0;
            $averageVote = 0;
            foreach ($professional->reviews as $review){
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
    public function professionalByReviewsNumber($rangeMin)
    {
        $professionals = Professional::with(["reviews", "specialties", "leads", "user"])->get();
        $professionals->each(function ($professional) {
            //se ho photo
            if ($professional->photo) {
                $professional->photo = url("storage/" . $professional->photo);
            } else {
                $professional->photo = url("img/not_found.jpg");
            }

        });
        $filtered = $professionals->filter(function ($professional) use ($rangeMin) {
            $reviewCounter = 0;
            foreach ($professional->reviews as $review) {
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
    public function professionalByAll($average, $rangeMin){
        $professionals = Professional::with(["reviews","specialties","leads","user"])->get();
        $professionals->each(function ($professional) {
            //se ho photo
            if ($professional->photo) {
                $professional->photo = url("storage/" . $professional->photo);
            } else {
                $professional->photo = url("img/not_found.jpg");
            }

        });
        $filtered = $professionals->filter(function($professional) use($average, $rangeMin){
            $reviewCounter = 0;
            $sum = 0;
            $averageVote = 0;
            foreach ($professional->reviews as $review){
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
            return $this->professionalByAvg($avg);
        } elseif (!isset($avg) && isset($rMin)){
            return $this->professionalByReviewsNumber($rMin);
        } else {
            return $this->professionalByAll($avg, $rMin);
        }
//        return $this->professionalByReviewsNumber($rMin, $rMax);

    }
//$average = null, $rangeMin = null, $rangeMax = null
    public function professionalsSponsored(){
        $professionals = Professional::with(['user', 'subscriptions', 'specialties', 'reviews'])->get();
        $professionals->each(function ($professional) {
            //se ho photo
            if ($professional->photo) {
                $professional->photo = url("storage/" . $professional->photo);
            } else {
                $professional->photo = url("img/not_found.jpg");
            }

        });
        $filtered = $professionals->filter(function($professional){
           $sponsorFilter = $professional->subscriptions->filter(function($sub){
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
