<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // index
    public function index()
    {
        $products = \App\Models\Product::paginate(5);
        return view('pages.product.index', compact('products'));
    }

    public function create()
    {
        $categories = DB::table('categories')->get();
        return view('pages.product.create', compact('categories'));
    }

    // store
    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'name' => 'required|max:255',
            'decription' => 'max:255',
            'price' => 'required|numeric',
            'stok' => 'required|numeric',
            'category_id' => 'required',
            'is_available' => 'required|boolean',
            'is_favorit' => 'required|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = new \App\Models\Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stok = $request->stok;
        $product->is_available = $request->is_available;
        $product->is_favorit = $request->is_favorit;
        $product->category_id = $request['category_id'];
        $product->save();

        // Save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAS('public/products', $product->id . '.' . $image->getClientOriginalExtension());
            $product->image = 'storage/products' . $product->id . '.' . $image->getClientOriginalExtension();
            $product->save();
        }

        return redirect()->route('product.index')->with('success', 'Produk berhasil ditambah!');
    }

    // edit
    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $categories = DB::table('categories')->get();
        return view('pages.product.edit', compact('product', 'categories'));
    }

    // update
    public function update(Request $request, $id)
    {
        // Validasi request
        $request->validate([
            'name' => 'required',
            'decription' => 'max:255',
            'price' => 'required|numeric',
            'stok' => 'required|numeric',
            'category_id' => 'required',
            'is_available' => 'boolean',
            'is_favorit' => 'required|boolean',
        ]);

        // Update Request
        $product = \App\Models\Product::find($id);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = (int) $request['price'];
        $product->stok = (int) $request['stok'];
        $product->category_id = $request->category_id;
        $product->is_available = $request->is_available;
        $product->is_favorit = $request->is_favorit;
        $product->save();

        // Save Image

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAS('public/products', $product->id . '.' . $image->getClientOriginalExtension());
            $product->image = 'storage/products' . $product->id . '.' . $image->getClientOriginalExtension();
            $product->save();
        }

        return redirect()->route('product.index')->with('success', 'Product successfully updated');
    }

    // show
    public function show($id)
    {
        $product = \App\Models\Product::find($id);
        return view('pages.product.show', compact('product'));
    }

    // destroy
    public function destroy($id)
    {
        $product = \App\Models\Product::find($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product successfully deleted');
    }
}
