<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return response(['data' => $categories]);
    }
    public function store(Request $request)
    {
        $category =new Category;
        $category->name = $request->name;
        $category->save();

        return response(['success'=>true],200);
    }
}
