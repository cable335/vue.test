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

    public function edit($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect(route('product.list'))->with(['message' => rtFormat($id, 0, '查無資料')]);
        }

        return Inertia::render('Backend/Product/EditProduct', ['response' => rtFormat($product)]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'formData.name' => 'required|max:255|string',
            'formData.price' => 'required|min:0|numeric',
            'formData.public' => 'required|numeric',
            'formData.desc' => 'max:255',
            'id' => 'required|exists:products,id',
        ], [
            'formData.name.required' => '商品名稱必填',
            'formData.name.max' => '商品名稱不得多於255個字',
        ]);
        $product = Product::find($request->id);

        // 轉物件
        // $formData = (object) $request->formData;
        $product->update([
            'name' => $request->formData['name'],
            'price' => $request->formData['price'],
            'public' => $request->formData['public'],
            'desc' => $request->formData['desc'],
        ]);
        return back()->with(['message' => rtFormat($product)]);
    }
}
