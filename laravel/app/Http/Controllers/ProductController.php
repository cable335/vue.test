<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(){
        $product = Product::orderBy('id','desc')->get()->map(function($item) {
            $item->timeFormat = $item->created_at->format('Y/m/d');
            return $item;
        });
        return Inertia::render('Backend/Product/Index', [ 'response' => rtFormat($product)]);
    }
    public function create(){
        return Inertia::render('Backend/Product/CreateProduct');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|min:0|numeric',
            'public' => 'required|numeric',
            'desc' => 'max:255',
        ]);

        $Product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'public' => $request->public,
            'desc' => $request->desc,
        ]);

        return back()->with(['message' => rtFormat($Product)]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
        ]);

        $Product = Product::find($request->id)->delete();

        return back()->with(['message' => rtFormat($Product)]);
    }
}
