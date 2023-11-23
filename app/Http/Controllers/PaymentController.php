<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;

class PaymentController extends Controller {

    public function processPayment(Request $request, $price) {
        try {
            // Used direct stripe charge as Laravel cashier is not working. Need deep analisys
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            \Stripe\Charge::create([
                'amount' => ($price * 100) * $request->input('qty'),
                'currency' => 'usd',
                'source' => 'tok_visa',
                'description' => 'Payment by ' . $request->input('card-holder-name') . ' for product ' . $request->input('product')
            ]);

            // This method is not working. Need to analyse in deep
            // $user = User::find(1);
            // $user->charge($price, $paymentMethod);
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Error creating subscription. ' . $e->getMessage()]);
        }
        return redirect('/products');
    }

}
