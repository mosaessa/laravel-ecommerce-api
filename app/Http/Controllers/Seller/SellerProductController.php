<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Seller $seller)
    {
        return $this->showAll($seller->products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $seller)
    {

        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'sometimes|required|image'
        ]);
        $data['status'] = Product::UNAVAILABLE_PRODUCT;
        $data['image'] = $request->image->store('');
        // $data['image'] = $request->image->store('');
        $data['seller_id'] = $seller->id;
        $product = Product::create($data);
        return $this->showOne($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Seller $seller, Product $product)
    {
        $product = $seller->products->where('id', $product->id)->first();
        if ($product) {
            return $this->showOne($product);
        }
        return $this->errorResponse('No data found with the specific identicator', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seller $seller, Product $product)
    {

        $data = $request->validate([
            'name' => 'sometimes|required',
            'description' => 'sometimes|required',
            'quantity' => 'sometimes|required|integer|min:1',
            'image' => 'sometimes|required|image',
            'status' => 'sometimes|required|in:'
                . Product::AVAILABLE_PRODUCT . ',' . Product::UNAVAILABLE_PRODUCT
        ]);

        $product = $seller->products->where('id', $product->id)->first();

        if ($product) {
            if ($request->has('status')) {
                if ($product->isAvailable() && $product->categories()->count() == 0) {
                    return $this->errorResponse('An active product must have at least on category', 409);
                }
            }
            if ($request->hasFile('image')) {
                Storage::delete($product->image);
                $data['image'] = $request->image->store('');
            }
            $product->fill($data);
            if ($product->isClean()) {
                return $this->errorResponse(
                    'You need to specif any defferent value to update',
                    400
                );
            }
            $product->save();
            return $this->showOne($product, 201);
        }
        return $this->errorResponse('No data found with the specific identicator', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seller $seller, Product $product)
    {
        $product = $seller->products->where('id', $product->id)->first();
        if ($product) {
            $product->delete();
            Storage::delete($product->image);
            return $this->showOne($product);
        }
        return $this->errorResponse('No data found with the specific identicator', 200);
    }
}
