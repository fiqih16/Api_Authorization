<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return response(['data' => $products]);
    }

    public function store(Request $request)
    {
        $product =new Product;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->image_link = $request->image_link;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->save();

        return response(['success'=>true],200);
    }

    public function show(Product $product)
    {
        $category = $product->category;
        return response(['data' => $product]);
    }

    public function searchByCategory(Category $category)
    {
        $products = $category->products;
        return response(['data' => $products]);
    }

    public function searchByKey(Request $request)
    {
        $products = Product::where('name', 'LIKE', "%$request->key%")
                           ->orWhere('description', 'LIKE', "%$request->key%")->get();
        return response(['data' => $products]);
    }
}
