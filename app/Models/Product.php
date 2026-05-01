<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Pastikan nama fungsi ini sama persis dengan yang ada di with('units')
    public function units()
    {
        // Ganti ProductUom dengan nama model yang Anda gunakan untuk tabel satuan
        return $this->hasMany(ProductUom::class, 'sku','sku');
    }

    public function activePromo()
    {
        // Mencari promo berdasarkan SKU yang statusnya aktif dan tanggalnya valid
        return $this->hasOne(Promo::class, 'sku', 'sku')
                    ->where('is_active', true)
                    ->where(function($query) {
                        $query->whereNull('start_date')
                              ->orWhere('start_date', '<=', now());
                    })
                    ->where(function($query) {
                        $query->whereNull('end_date')
                              ->orWhere('end_date', '>=', now());
                    });
    }
}
