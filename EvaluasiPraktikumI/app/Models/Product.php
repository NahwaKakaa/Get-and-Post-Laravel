<?php

// app/Models/Product.php 
namespace App\Models; 
 
class Product 
{ 
    public static function all() 
    { 
        return session('products', []); 
    } 
 
    public static function create($data) 
    { 
        $product = session('products', []); 
        
        // Cek duplikasi nama produk
        foreach ($product as $existingProduct) {
            if ($existingProduct['name'] === $data['name']) {
                return ['error' => 'Nama produk telah tersedia.'];
            }
        }
        
        $data['id'] = count($product) + 1; 
        $product[] = $data; 
        session(['products' => $product]); 
        return $data; 
    } 

    public static function find($id)
    {
        $products = session('product', []);

        // Cari produk berdasarkan ID
        foreach ($products as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }

        return null; // Kembalikan null jika tidak ditemukan
    }
}
