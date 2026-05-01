<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class TransactionController extends Controller
{
    //Halaman Transaction
    public function index(){
        $data = [
            'transaction_id' => '123'
        ];
        return view('transaction.transaction', $data);
    }

    public function getProduct($id){
        $product = Product::with(['units', 'activePromo'])
                    ->where('sku', $id)
                    ->orWhere('name', 'like', "%$id%")
                    ->first();
        if ($product) {
            return response()->json($product);
        }

        return response()->json(['message' => 'Produk tidak ditemukan'], 404);
    }
}
