<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserTransactionNotification;

class CheckoutController extends Controller
{   

    public function process(Request $request){
        // Save User Data
        $user = Auth::user();
        /* dd($request->all()); */
      /*   $user->update($request->except('total_price')); */

        // Proses Checkout
        $code = 'TRX-' .  mt_rand(000000,999999);
        $carts =  Cart::with(['product','user'])
                    ->where('users_id', Auth::user()->id)
                    ->get();
        
        // Transaction Create
        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'tax_price' => 0,
            'total_price' => $request->total_price,
            'transaction_status' => 'PENDING',
            'code' => $code,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes
        ]);

        // Foreach Transaction Detail
        foreach ($carts as $cart) {
    
            $trx = 'STF-' . mt_rand(000000,999999);

            $products = Product::with(['category'])->get();

            $quantity = $cart->quantity;

            for ($i = 0; $i < $quantity; $i++) {
            $product = $products->find($cart->product->id);

            TransactionDetail::create([
            'transactions_id' => $transaction->id,
            'products_id' => $cart->product->id,
            'price' => $cart->product->price,
            'delivery_status' => 'PENDING',
            'code' => $trx,
            'notes' => Auth::user()->notes,
            'payment_method' => Auth::user()->payment_method
        ]);

            $product->decrement('quantity');
            }
        }
        
        $admin = User::where('id', 4)->first();

        Notification::send(User::find($admin), new UserTransactionNotification($user));

        // Delete Cart Data
        Cart::where('users_id', Auth::user()->id)->delete();

        return redirect()->route('transaction-user');
        

    }
}
