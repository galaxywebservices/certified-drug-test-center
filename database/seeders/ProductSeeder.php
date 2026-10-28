<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $prodFile = database_path('seeders/data/products.json');
        if (File::exists($prodFile)) {
            $products = json_decode(File::get($prodFile), true);
            foreach ($products as $prod) {
                Product::updateOrCreate(['slug' => $prod['slug']], $prod);
            }
        }

        $pivotFile = database_path('seeders/data/category_product.json');
        if (File::exists($pivotFile)) {
            $pivots = json_decode(File::get($pivotFile), true);
            foreach ($pivots as $pivot) {
                DB::table('category_product')->updateOrInsert(
                    [
                        'category_id' => $pivot['category_id'],
                        'product_id' => $pivot['product_id'],
                    ],
                    [
                        'position' => $pivot['position'] ?? 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
