<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $carts = Cart::all();

        return response(['data' => $carts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = $request->user()->id;
        $cart = Cart::where('user_id', $userId)
                ->where('product_id', $request->product_id)->first();
        // jika ada data yang sama
        if($cart != null){
            //Akan menambahkan quantity
            $quantity = $cart->quantity;
            $newQuantity = $quantity + ($request->quantity);
            Cart::where('user_id', $userId)
                ->where('product_id', $request->product_id)
                ->update(['quantity'=> $newQuantity]);
        }else{
            //Akan menambahkan record baru
            $detail =new Cart;
            $detail->product_id = $request->product_id;
            $detail->price = $request->price;
            $detail->quantity = $request->quantity;
            $detail->user_id = $userId;
            $detail->save();
        }
        return response(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }
    /**
     * Display the specified resource by user
     */
    public function showByUser(Request $request)
    {

        $userId = $request->user()->id;

        $carts = Cart::where('user_id', $userId)
                ->with('user')
                ->with('product')
                ->with('product.category')
                ->get();
        return response(['data' => $carts]);

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
        
    }
}
