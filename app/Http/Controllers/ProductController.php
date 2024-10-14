<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->all();

        // logika untuk upload gambar
        if ($image = $request->file('image')) {
            $targetPath = 'assets/images/';
            $product_img = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($targetPath, $product_img);
            $input['image'] = "$product_img";
        }

        Product::create($input);

        return redirect()->route('products.index')->with(
            'success',
            'Product Created Successfully'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $input = $request->all();

        if ($image = $request->file('image')) {
            $targetPath = 'assets/images/';
            // gambar lama dihapus
            if ($product->image) {
                unlink($targetPath . $product->image);
            }

            $product_img = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($targetPath, $product_img);
            $input['image'] = "$product_img";
        } else {
            unset($input['image']);
        }

        $product->update($input);
        return redirect()->route('products.index')->with(
            'success',
            'Products berhasil diupdate'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // hapus gambar permanent
        $target = 'assets/images/';
        if ($product->image) {
            unlink($target . $product->image);
        }
        // hapus data permanent
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus permanen');
    }
}
