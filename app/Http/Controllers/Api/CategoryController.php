<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // index api
    public function index(){
        // get all categories
        $categories = Category::all();
        // return json response
        return response()->json([
            'status' => 'success',
            'categories' => $categories
        ], 200);
    }
}
