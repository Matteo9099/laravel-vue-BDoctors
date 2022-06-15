<?php

use App\Http\Controllers\Api\ProfessionalController;

use App\Http\Controllers\Api\SpecialtyController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:api")->get("/user", function (Request $request) {
    return $request->user();
});

//api get specialties
Route::get("/", [SpecialtyController::class, "getSpecialties"]);

//api provvisorio per ottenere i dottori nella HOME
Route::get("/docs/{specialtySlug?}", [ProfessionalController::class, "getAllprofessionals"]);

// api professional paginate 10
Route::get("/professionals", [ProfessionalController::class, "index"]);
//api singolo dottore per slug
Route::get("/professionals/{slug}", [ProfessionalController::class, "show"]);
// api lead dottore
Route::post("/leads", [LeadController::class, "store"]);
Route::post("/review", [ReviewController::class, "store"]);

// api reviews per dottore ordinate per data
Route::get("/reviews/{professionalId}", [ReviewController::class, "index"]);


//api per fascia voto
/*Route::get("/professionals/filter/{average}", [
    ProfessionalController::class,
    "professionalByVote",
]);*/
// api per numero di recensioni
Route::get('/filter', [ProfessionalController::class, 'filter'] );

//api per sponsorizzati
Route::get('/sponsored',[ProfessionalController::class, 'professionalsSponsored']);
Route::get('/sponsored',[ProfessionalController::class, 'professionalsSponsored']);
