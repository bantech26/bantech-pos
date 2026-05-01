<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 1000; $i++) {
            // Menggunakan EAN-13 (13 digit angka saja) untuk SKU
            $barcodeSku = $faker->unique()->ean13(); 
            $basePrice = $faker->numberBetween(1000, 50000);
            
            // 1. Insert ke tabel products
            DB::table('products')->insert([
                'name'       => $faker->words(3, true),
                'sku'        => $barcodeSku, // Sekarang berisi 13 digit angka
                'base_uom'   => 'pcs',
                'base_price' => $basePrice,
                'stock'      => $faker->numberBetween(100, 1000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2. Variasi Satuan (UOM)
            $uomVariations = [
                ['name' => 'box', 'factor' => 12],
                ['name' => 'dus', 'factor' => 48],
                ['name' => 'koli', 'factor' => 144],
            ];

            foreach ($uomVariations as $v) {
                DB::table('product_uoms')->insert([
                    'sku'               => $barcodeSku, // Sama dengan SKU 13 digit
                    'uom_name'          => $v['name'],
                    'conversion_factor' => $v['factor'],
                    'price'             => $basePrice * $v['factor'],
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
            }
        }
    }
}