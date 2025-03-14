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

    public function edit($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $categories = Category::all(); // Jika kategori diperlukan

        return view('admin.edit-product', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'category' => 'required',
            'price' => 'required',
            'description' => 'required',
            'stock' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->product_name = $request->name;
        $product->category_id = $request->category;
        $product->product_price = $request->price;
        $product->product_description = $request->description;
        $product->product_stock = $request->stock;

        // Cek apakah ada file gambar yang diupload
        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $imageName = time() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('images'), $imageName);

        //     if ($product->product_image && file_exists(public_path('images/' . $product->product_image))) {
        //         unlink(public_path('images/' . $product->product_image));
        //     }

        //     $product->product_image = $imageName;
        // }

        // if ($request->hasFile('image')) {
        //     dd('File ditemukan', $request->file('image'));
        // } else {
        //     dd('File tidak ditemukan');
        // }

        $product->save();

        return redirect()->route('product-admin')->with('success', 'Product berhasil diperbarui');
    }
}
