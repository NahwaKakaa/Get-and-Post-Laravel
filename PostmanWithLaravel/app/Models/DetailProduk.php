<?php

namespace App\Models;

class DetailProduk
{
    public static function all()
    {
        return session('products', []);
    }

    public static function find($id)
    {
        $products = session('products', []);

        foreach ($products as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }
        return null;
    }

    public static function create($data)
    {
        $products = session('products', []);
        $data['id'] = count($products) + 1;
        $products[] = $data;
        session(['products' => $products]);

        return $data;
    }
}
