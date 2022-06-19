<?php

use App\Http\Controllers\Api\DoctorController;

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
Route::get("/docs/{specialtySlug?}", [DoctorController::class, "getAllDoctors"]);

// api doctor paginate 10
Route::get("/doctors", [DoctorController::class, "index"]);
//api singolo dottore per slug
Route::get("/doctors/{slug}", [DoctorController::class, "show"]);
// api lead dottore
Route::post("/leads", [LeadController::class, "store"]);
Route::post("/review", [ReviewController::class, "store"]);

// api reviews per dottore ordinate per data
Route::get("/reviews/{doctorId}", [ReviewController::class, "index"]);


//api per fascia voto
/*Route::get("/doctors/filter/{average}", [
    DoctorController::class,
    "doctorByVote",
]);*/
// api per numero di recensioni
Route::get('/filter', [DoctorController::class, 'filter'] );

//api per sponsorizzati
Route::get('/sponsored',[DoctorController::class, 'doctorsSponsored']);
Route::get('/sponsored',[DoctorController::class, 'doctorsSponsored']);
