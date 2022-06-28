<?php

namespace App\Http\Controllers;
use Mail;

use Stripe\Charge;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    public function index () {
        if(Cart::content()->count() == 0)
        {
            session()->flash('info','your cart is empty do some shopping');
            return redirect()->back();
        }
        return view('checkout');
    }
    public function pay () {

        Stripe::setApiKey("sk_test_51I1EVoEU1VpmOPloFt9BCxPxvmRTWowsCDmiuIaq89gcWzCPU08ilbHlbmfivYCAwp38LmDY8GD9ZxPixVd2o9UK00Zbp2ywAU");

        $token = request()->stripeToken;

        $charge = PaymentIntent::create([
            'amount' => 1000,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
            'receipt_email' => 'jenny.rosen@example.com',
        ]);
        

        session()->flash('success','Pursache comeplete');
        Cart::destroy();
        Mail::to(request()->stripeEmail)->send(new \App\Mail\PurchaseSuccessful);
        return redirect('/');
    }
}
