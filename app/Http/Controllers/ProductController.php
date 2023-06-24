<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\MyApp;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    use HttpResponses;

    public function __construct()
    {
        $this->middleware('ability:admin')->only(['store', 'update', 'destroy']);
    }


    public function index()
    {
        try {
            $product = Product::withoutTrashed()->get();
            return $this->success($product);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(ProductRequest $request)
    {
        try {
            $request->validated($request->all());

            $product = Product::create([
                'code' => $request->code,
                'name' => $request->name,
                'price' => $request->price,
                'currency' => $request->currency,
                'discount' => $request->discount,
                'dimension' => $request->dimension,
                'unit' => $request->unit,
                'created_by' => Auth::user()->id,
            ]);

            return $this->success($product, MyApp::INSERTED_SUCCESSFULLY);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Product $product)
    {
        try {
            return $this->success($product);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(ProductRequest $request, Product $product)
    {
        try {
            $product->code = $request->code;
            $product->name = $request->name;
            $product->price = $request->price;
            $product->currency = $request->currency;
            $product->discount = $request->discount;
            $product->dimension = $request->dimension;
            $product->unit = $request->unit;
            $product->updated_by = Auth::user()->id;

            $product->save();

            return $this->success($product, MyApp::UPDATED_SUCCESSFULLY);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->deleted_by = Auth::user()->id;
            $product->save();
            $product->delete();

            return $this->success(null, MyApp::DELETED_SUCCESSFULLY);
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), MyApp::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
