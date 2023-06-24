<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Cart;
use App\MyApp;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    use HttpResponses;

    public function index()
    {
        try {
            $cart = Cart::where('user_id', Auth::user()->id)->get();
            return $this->success($cart);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreCartRequest $request)
    {
        try {
            $request->validated($request->all());

            $cart = Cart::create([
                'user_id' => Auth::user()->id,
                'product_code' => $request->product_code,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'unit' => $request->unit,
                'sub_total' => $request->price * $request->quantity,
                'currency' => $request->currency,
            ]);

            return $this->success($cart, MyApp::INSERTED_SUCCESSFULLY);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Cart $cart)
    {
        try {
            return $this->success($cart);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateCartRequest $request, Cart $cart)
    {
        try {
            $cart->quantity = $request->quantity;
            $cart->sub_total = $request->quantity * $cart->price;
            $cart->save();

            return $this->success($cart, MyApp::UPDATED_SUCCESSFULLY);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Cart $cart)
    {
        try {
            $cart->delete();

            return $this->success(null, MyApp::DELETED_SUCCESSFULLY);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
