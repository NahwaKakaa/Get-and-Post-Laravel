<?php

// app/Http/Controllers/BeliController.php 
namespace App\Http\Controllers; 
 
use App\Models\Beli; 
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request; 
 
class BeliController extends Controller 
{ 
    public function store(Request $request) 
    { 
        $request->validate([ 
            'user_id' => 'required|integer', 
            'product_id' => 'required|integer', 
            'quantity' => 'required|integer|min:1', 
        ]); 
 
        $users = User::all();
        $products = Product::all();
        
        $userExists = collect($users)->firstWhere('id', $request->user_id);
        if (!$userExists) {
            return response()->json(['error' => 'Pengguna tidak ditemukan'], 400);
        }

        $product = collect($products)->firstWhere('id', $request->product_id);
        if (!$product) {
            return response()->json(['error' => 'Produk tidak ditemukan'], 400);
        }

        if ($product['stock'] < $request->quantity) {
            return response()->json(['error' => 'Stok kurang'], 400);
        }

        // Kurangi stok produk setelah pembelian berhasil
        foreach ($products as &$p) {
            if ($p['id'] === $request->product_id) {
                $p['stock'] -= $request->quantity;
            }
        }
        session(['product' => $products]);

        $purchase = Beli::create($request->only(['user_id', 'product_id', 'quantity'])); 
        return response()->json($purchase, 201); 
    }  
 
    public function index() 
    { 
        return response()->json(Beli::all(), 200); 
    } 
} 