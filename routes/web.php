<?php
use App\Http\Controllers\NotFoundController;
use App\Http\Controllers\Admin\SubscriptionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware('auth')
    ->namespace('Admin')
    ->name('admin.')
    ->prefix('admin')
    ->group(
        function () {
            // rotta dashboard
            Route::get('/', 'HomeController@index')->name('home');
            //rotta destroy user dashboard
            Route::delete('/{user}', 'HomeController@destroy')->name('home.destroy');
            Route::get('/{user}', 'HomeController@show')->name('home.show');

            // rotte CRUD dottore
            Route::resource('doctors', 'DoctorController');


            //rotta get e delete cv
            Route::get('/cvDownload', 'CvController@getCv')->name('downloadCv');
            Route::get('cvDelete/{doctor}', 'CvController@cvDelete')->name('deleteCv');
            //rotta delete photo
            Route::get('/photoDelete/{doctor}', "PhotoController@photoDelete")->name('deletePhoto');
            // rotta index review
            Route::get('/doctors/{slug}/reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews');
            // api reviews per risposta del dottore
            Route::post('/reviews/response/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'store'])->name('reviewDoctorRes');
            // rotta index Leads
            Route::get('/doctors/{slug}/leads', [\App\Http\Controllers\Admin\LeadController::class, 'index'])->name('leads');
            // api leads per risposta del dottore
            Route::post('/leads/response/{lead}', [\App\Http\Controllers\Admin\LeadController::class, 'store'])->name('leadDoctorRes');

            //rotte per subs
            Route::get('/subscriptions/{doctor}', [SubscriptionController::class, 'index'])->name('subscription.index');
            Route::get('/checkout/{type}', [SubscriptionController::class, 'token'])->name('subscription.pay');
            Route::post('/checkout/{price}', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');

            // rotte per chars
            Route::get('/charts/{doctor}', [\App\Http\Controllers\Admin\DoctorController::class, 'charts'])->name('charts');
        }
    );

Route::get("/", function () {
    return view('guests.home');
})->name('guests.home');

// rotta 404
Route::get('/notfound', [NotFoundController::class, 'index'])->name('404');
Route::get('/unauthorized', [NotFoundController::class, 'unauthorized'])->name('401');


Route::get('{any?}', function () {
    return view('guests.home');
})->where('any', '.*');
