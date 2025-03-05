<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function product(Request $request)
    {
        $categories = Category::all();
        $products = Product::with('category')->get();
        $selectedProduct = null;

        // Jika ada parameter 'id', ambil produk berdasarkan ID
        if ($request->has('id')) {
            $selectedProduct = Product::with('category')->find($request->id);
        }

        return view('pages.admin.product', [
            'categories' => $categories,
            'products' => $products,
            'selectedProduct' => $selectedProduct,
        ]);
    }

    public function addProduct(Request $request)
    {
        // Validasi Input
        $this->validate($request, [
            'name' => 'required',
            'category' => 'required',
            'price' => 'required',
            'description' => 'required',
            'stock' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Simpan Data ke Database\
        $imageName = $request->image->getClientOriginalName();
        $request->image->move(public_path('images'), $imageName);
        $product = new Product();
        $product->product_name = $request->name;
        $product->category_id = $request->category;
        $product->product_price = $request->price;
        $product->product_description = $request->description;
        $product->product_stock = $request->stock;
        $product->product_image = $imageName;
        // dd($request->all()); // Debugging
        $product->save();

        return redirect()->route('product-admin')->with('success', 'Product berhasil ditambahkan');
    }
}
