<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [1, 'Cà phê đá', 5, 20000],
            [2, 'Cà phê sữa', 5, 20000],
            [3, 'Bạc xỉu', 5, 20000],
            [4, 'Sting', 5, 20000],
            [5, 'Nước ép cam', 4, 15000],
            [6, 'Nước ép dưa hấu', 4, 15000],
            [7, 'Nước ép táo', 4, 15000],
            [8, 'Nước ép dứa', 4, 15000],
            [9, 'Nước ép đào', 4, 15000],
            [10, 'Nước ép quất', 4, 20000],
            [11, 'Sinh tố dâu', 4, 20000],
            [12, 'Sinh tố bơ', 4, 25000],
            [13, 'Sinh tố mãng cầu', 4, 25000],
            [14, 'Sinh tố mít', 4, 25000],
            [15, 'Ca cao đá xay', 4, 25000],
            [16, 'Trà sữa truyền thống', 4, 25000],
            [17, 'Trà sữa matcha', 4, 20000],
            [18, 'Trà sữa socola', 4, 10000],
            [19, 'Trà sữa khoai môn', 4, 10000],
            [20, 'Nước suối', 4, 10000],
            [21, 'Pepsi', 4, 10000],
            [22, 'Coca', 4, 20000],
            [23, 'Mì ly', 3, 20000],
            [24, 'Mì hộp', 3, 10000],
            [25, 'Mì gói', 3, 10000],
            [26, 'Hủ tiếu gói', 3, 15000],
            [27, 'Hủ tiếu hộp', 3, 15000],
            [28, 'Bún xào', 3, 30000],
            [29, 'Cơm chiên dương châu', 3, 30000],
            [30, 'Cơm sườn', 3, 30000],
        ];

        foreach ($products as $key => $product) {
            Product::create([
                'id' => $product[0],
                'company_id' => 1,
                'name' => $product[1],
                'price' => $product[3],
            ]);

            DB::table('catalogue_product')->insert([
                'catalogue_id' => $product[2],
                'product_id' => $product[0],
            ]);
        }
    }
}
