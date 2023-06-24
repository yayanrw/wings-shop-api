<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\MyApp;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    use HttpResponses;
    public function createTransactionFromCart()
    {
        try {
            $document_code = 'TRX';
            $document_number = date('Ymd') . Auth::user()->id . Str::random(1);

            // get all cart from own user
            $carts = Cart::where('user_id', Auth::user()->id)->get();
            $total = 0;

            foreach ($carts as $cart) {
                $total += $cart->sub_total;
            }

            // create header
            $transaction = Transaction::create([
                'document_code' => $document_code,
                'document_number' => $document_number,
                'user' => Auth::user()->id,
                'total' => $total,
                'date' => date('Y-m-d'),
            ]);

            // create details
            foreach ($carts as $cart) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'document_code' => $document_code,
                    'document_number' => $document_number,
                    'product_code' => $cart->product_code,
                    'price' => $cart->price,
                    'quantity' => $cart->quantity,
                    'unit' => $cart->unit,
                    'sub_total' => $cart->sub_total,
                    'currency' => $cart->currency,
                ]);
            }

            //delete carts
            Cart::where('user_id', Auth::user()->id)->delete();

            return $this->success(null, MyApp::INSERTED_SUCCESSFULLY);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
