<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FrontController extends Controller
{
    public function home(){
        $product = Product::orderBy('id', 'desc')->where('public', 1)->get();

        return Inertia::render('Frontend/Index', [
            'response' => rtFormat($product),
        ]);
    }
    public function addCart(Request $request){
        $request->validate(([
            'id' => 'required|numeric|exists:products,id',
            'qty' => 'required|numeric|min:1',
        ]));

        $cart = Cart::where('product_id', $request->id)->where('user_id', $request->user()->id)->first();

        if ($cart) {
            $cart->update([
                'qty' => $request->qty + $cart->qty,
            ]);
        } else {
            $cart = Cart::create([
                'product_id' => $request->id,
                'qty' => $request->qty,
                'user_id' => $request->user()->id,
            ]);
        }

        return back()->with(['message' => rtFormat($cart->id)]);
    }
}
