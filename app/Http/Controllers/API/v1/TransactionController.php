<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Cart;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $carts = Cart::where('user_id', $userId)->get();
        if(count($carts) != 0){
            //save to transaction
            $transaction =new Transaction;
            $transaction->datetime = Carbon::now();
            $transaction->user_id = $userId;
            $transaction->save();

            //save to product_transaction
            $totalCost = 0;
            foreach($carts as $cart){
                $totalCost += (($cart->quantity)*($cart->price));
                $transaction->products()
                ->attach($cart->product_id,
                ['quantity'=>$cart->quantity,'price'=>$cart->price]);
            }
            //update total_cost in transaction
            $transaction = Transaction::where('id', $transaction->id);
            $transaction->update(['total_cost'=>$totalCost]);
            //delete cart
            Cart::where('user_id', $userId)->delete();
            return response(['success' => true]);
        }else{
            return response(['success' => false,
             'message' => 'The carts is empty']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
