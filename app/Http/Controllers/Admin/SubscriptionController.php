<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    //index
    public function index($slug){
        if(Auth::user()->professional->slug == $slug){
            $bronze = Subscription::whereId(1)->first();
            $silver = Subscription::whereId(2)->first();
            $gold = Subscription::whereId(3)->first();
            return view('Admin.Subscription.homesubscription', compact('bronze', 'silver', 'gold'));
        } else{
            return redirect()->route('401');
        }
    }
    public function token($type){
        // qui inizializzo braintree
        $gateway = new \Braintree\Gateway([
            // i dati li riprendiamo dal config precedentemente inizializzato
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);

        // genero il token e lo passo alla rotta, dentro la rotta in var client_token (script) mi riferisco a questo
        $token = $gateway->ClientToken()->generate();
        $subscription = Subscription::where('name', $type)->first();
        return view('Admin.Subscription.braintree', ['token' => $token, 'type' => $subscription]);
    }

    public function checkout(Request $request, $price){
        $professional = Auth::user()->professional;
//        $professional->subscriptions()->sync([1]);
        if(count($professional->subscriptions) > 0){
            $professionalLastSub = $professional->subscriptions()->orderByDesc('pivot_expires_at', 'asc')->first();
    //        dd($professionalLastSub->pivot->expires_at);
            $lastSubDate = new Carbon($professionalLastSub->pivot->expires_at);
        } else {
//            dd($professional->subscriptions);
            $lastSubDate = Carbon::yesterday()->addDays(1);
//            dd($lastSubDate);
        }
        $subscription = Subscription::wherePrice($price)->first();
        $subId = $subscription->id;
        // prendi l'ultima sub e aggiungi
        if($price == 2.99){
            $expires = $lastSubDate->addDays(1);
//            dd($expires);
        } elseif($price == 5.99){
            $expires = $lastSubDate->addDays(3);
        } else {
            $expires = $lastSubDate->addDays(6);
        }
//        $professional->subscriptions()->attach($subId, ['expires_at' => $expires]);
//        dd($professional);
        $gateway = new \Braintree\Gateway([
            // i dati li riprendiamo dal config precedentemente inizializzato
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);

        // questi dati li ricevo da request
        $amount = $price;
        $nonce = $request->payment_method_nonce;
//        dd($nonce);
        $result = $gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            $professional->subscriptions()->attach($subId, ['expires_at' => $expires]);
            return view('Admin.Subscription.checkout', compact('subscription', 'expires'));
        } else {
            $errorString = "";

            foreach($result->errors->deepAll() as $error) {
                $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
            }
            $_SESSION["errors"] = $errorString;
//            header("Location: " . $baseUrl . "index.php");
            return view('Admin.Subscription.errorCheckout', compact('subscription', 'errorString'));
        }
    }

}
