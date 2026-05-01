<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //Halaman Transaction
    public function index(){
        return view(transaction.transaction);
    }

    public function getProduct($id){
        $product = Product::with('units') // Ambil data Multi-UOM-nya sekalian
                    ->where('sku', $identifier)
                    ->orWhere('name', 'like', "%$identifier%")
                    ->first();

        if ($product) {
            return response()->json($product);
        }

        return response()->json(['message' => 'Produk tidak ditemukan'], 404);
    }

    public function search(Request $request) {
    $query = $request->get('q');
    
    // Gunakan limit (misal: 10) agar respon tetap instan
    $products = Product::where('name', 'LIKE', "%{$query}%")
                        ->orWhere('sku', 'LIKE', "%{$query}%")
                        ->limit(10)
                        ->get();

    return response()->json($products);
    }

}
