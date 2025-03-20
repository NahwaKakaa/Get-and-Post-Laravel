<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $product = Product::create($request->only(['name', 'price', 'stock', 'description']));

        return response()->json($product, 201);
    }

    public function index()
    {
        return response()->json(Product::all(), 200);
    }

    public function show($id)
    {
    // Ambil semua produk dari sesi
    $products = session('products', []);

    // Cari produk berdasarkan ID
    foreach ($products as $product) {
        if ($product['id'] == $id) {
            return response()->json($product, 200);
        }
    }

    // Jika tidak ditemukan, kirimkan respon error
    return response()->json(['error' => 'Produk tidak ditemukan'], 404);
    }
}
