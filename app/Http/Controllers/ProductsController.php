<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Categories;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Products::with('category');
        if ($search) {
            $query->where('product_name', 'like', '%' . $search . '%');
        }
        $products = $query->latest()->paginate(10);

        return view('products.index', compact('products', 'search'));
    }

    public function create()
    {
        $categories = Categories::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
        ]);
        Products::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function show(Products $products)
    {
        //
    }

    public function edit(Products $products)
    {
        $categories = Categories::all();
        return view('products.edit', compact('products', 'categories'));
    }


    public function update(Request $request, Products $products)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
        ]);

        $products->update($request->all());

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Products $products)
    {
        $products->delete();

        return redirect()->route('products.index')
            ->with('success', 'Data berhasil dihapus');
    }
}

/**
 * Show the form for creating a new resource.
 */


/**
 * Store a newly created resource in storage.
 */




/**
 * Display the specified resource.
 */


/**
 * Show the form for editing the specified resource.
 */


/**
 * Update the specified resource in storage.
 */





/**
 * Remove the specified resource from storage.
 */
