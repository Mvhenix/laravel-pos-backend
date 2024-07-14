<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // index
    public function index(){
        $categories = \App\Models\Category::paginate(5);
        return view('pages.categories.index', compact('categories'));
    }

    // create
    public function create(){
        return view('pages.categories.create');
    }

    // store
    public function store(Request $request){
        $request->validate([
            'name' =>'required|max:255',
            'description' =>'max:255',
            'image' =>'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // store the request
        $category = new \App\Models\Category;
        $category->name = $request->name;
        $category->description = $request->description;

        // save image
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image->storeAs('public/categories', $category->id . '.' .$image->getClientOriginalExtension());
            $category->image = 'storage/categories' . $category->id . '.' . $image->getClientOriginalExtension();
            $category->save();
        }

        \App\Models\Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    // show
    public function show($id){
        return view('pages.categories.show');
    }

    // edit
    public function edit($id){
        $category = \App\Models\Category::find($id);
        return view('pages.categories.edit', compact('category'));
    }

    // update
    public function update(Request $request, $id){
        $request->validate([
            'name' =>'required|max:255',
            'description' =>'max:255',
            // 'image' =>'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // update the request
        $category = \App\Models\Category::find($id);
        $category->name = $request->name;
        $category->description = $request->description;

        // save image
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image->storeAs('public/categories', $category->id . '.' .$image->getClientOriginalExtension());
            $category->image = 'storage/categories' . $category->id . '.' . $image->getClientOriginalExtension();
            $category->save();
        }

        return redirect()->route('categories.index')->with('success', 'Category successfully updated');
    }

    // destroy
    public function destroy($id){
        $category = \App\Models\Category::find($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
