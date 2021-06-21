<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();
        $productId = $request->productId;

        $lastProduct = $user->products()->orderBy('order_id', 'DESC')->first();
        $orderId = 1;
        if($lastProduct)
        {
            if($lastProduct->pivot->status == 'cart')
            {
                $orderId = $lastProduct->pivot->order_id;
            }
            else
            {
                $orderId = $lastProduct->pivot->order_id + 1;
            }
        }

        $price = Product::find($productId)->price;
        $today = Carbon::now();

        $user->products()->attach($productId, [
            'order_id' => $orderId,
            'price' => $price,
            'quantity' => $request->quantity,
            'order_at' => $today,
            'status' => 'cart'
        ]);

        return response(['status' => true]);
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        $productId = $request->productId;

        $user->products()->wherePivot('status', 'cart')->detach($productId);

        return response(['status' => true]);
    }

    public function cart(Request $request)
    {
        $user = $request->user();

        $cart = $user->products()->wherePivot('status', 'cart')->get();
        $cart->load('category');
        return response(['data' => $cart]);
    }

    public function history(Request $request)
    {
        $user = $request->user();

        $cart = $user->products()
              ->with('category')
              ->wherePivot('status', '!=', 'cart')
              ->orderBy('checkout_at', 'DESC')->get()
              ->groupBy('pivot.checkout_at');
        return response(['data' => $cart]);
    }

    public function checkout(Request $request)
    {
        $user = $request->user();

        $cart = $user->products()->wherePivot('status', 'cart')->get();
        foreach($cart as $item)
        {
            $user->products()
                 ->wherePivot('status', 'cart')
                 ->updateExistingPivot($item->id, [
                    'status' => 'checkout',
                    'checkout_at' => Carbon::now()
                 ]);
        }
        return response(['status' => true]);
    }
}
