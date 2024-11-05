<?php

namespace Database\Seeders;

use App\Models\Variable;
use Illuminate\Database\Seeder;

class VariableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $variables = [
            // product_id, name, image, unit, price, quantity, status
            [1, 'Cà phê đá Size M', null, 'Ly', 20000, 100, 1],
            [1, 'Cà phê đá Size L', null, 'Ly', 25000, 80, 1],
            [1, 'Cà phê đá Size XL', null, 'Ly', 30000, 60, 1],
            [2, 'Cà phê sữa Size M', null, 'Ly', 22000, 90, 1],
            [2, 'Cà phê sữa Size L', null, 'Ly', 27000, 70, 1],
            [2, 'Cà phê sữa Size XL', null, 'Ly', 32000, 50, 1],
            [3, 'Bạc xỉu Regular', null, 'Ly', 18000, 100, 1],
            [3, 'Bạc xỉu Large', null, 'Ly', 23000, 80, 1],
            [4, 'Sting Regular', null, 'Chai', 15000, 120, 1],
            [4, 'Sting Large', null, 'Chai', 20000, 100, 1],
            [5, 'Nước ép cam Size M', null, 'Chai', 18000, 90, 1],
            [5, 'Nước ép cam Size L', null, 'Chai', 22000, 70, 1],
            [6, 'Nước ép dưa hấu Size M', null, 'Chai', 19000, 80, 1],
            [6, 'Nước ép dưa hấu Size L', null, 'Chai', 24000, 60, 1],
            [7, 'Nước ép táo Size M', null, 'Chai', 21000, 100, 1],
            [7, 'Nước ép táo Size L', null, 'Chai', 26000, 50, 1],
            [8, 'Nước ép dứa Size M', null, 'Chai', 20000, 90, 1],
            [9, 'Nước ép đào Size M', null, 'Chai', 22000, 70, 1],
            [10, 'Nước ép quất Size M', null, 'Chai', 25000, 80, 1],
            [11, 'Sinh tố dâu Regular', null, 'Ly', 25000, 100, 1],
            [11, 'Sinh tố dâu Large', null, 'Ly', 30000, 50, 1],
            [12, 'Sinh tố bơ Regular', null, 'Ly', 26000, 90, 1],
            [12, 'Sinh tố bơ Large', null, 'Ly', 31000, 40, 1],
            [13, 'Sinh tố mãng cầu Regular', null, 'Ly', 24000, 80, 1],
            [13, 'Sinh tố mãng cầu Large', null, 'Ly', 29000, 60, 1],
            [14, 'Sinh tố mít Regular', null, 'Ly', 22000, 70, 1],
            [15, 'Ca cao đá xay Regular', null, 'Ly', 18000, 100, 1],
            [15, 'Ca cao đá xay Large', null, 'Ly', 23000, 50, 1],
            [16, 'Trà sữa truyền thống Regular', null, 'Ly', 20000, 100, 1],
            [16, 'Trà sữa truyền thống Large', null, 'Ly', 25000, 70, 1],
            [17, 'Trà sữa matcha Regular', null, 'Ly', 21000, 90, 1],
            [17, 'Trà sữa matcha Large', null, 'Ly', 26000, 50, 1],
            [18, 'Trà sữa socola Regular', null, 'Ly', 22000, 80, 1],
            [18, 'Trà sữa socola Large', null, 'Ly', 27000, 60, 1],
            [19, 'Trà sữa khoai môn Regular', null, 'Ly', 23000, 70, 1],
            [20, 'Nước suối 500ml', null, 'Chai', 10000, 150, 1],
            [20, 'Nước suối 1L', null, 'Chai', 15000, 100, 1],
            [21, 'Pepsi 500ml', null, 'Chai', 12000, 150, 1],
            [21, 'Pepsi 1L', null, 'Chai', 18000, 90, 1],
            [22, 'Coca 500ml', null, 'Chai', 12000, 150, 1],
            [22, 'Coca 1L', null, 'Chai', 18000, 90, 1],
            [23, 'Mì ly Regular', null, 'Gói', 12000, 200, 1],
            [23, 'Mì ly Large', null, 'Gói', 15000, 150, 1],
            [24, 'Mì hộp Regular', null, 'Hộp', 20000, 100, 1],
            [25, 'Mì gói Regular', null, 'Gói', 8000, 250, 1],
            [25, 'Mì gói Special', null, 'Gói', 10000, 200, 1],
            [26, 'Hủ tiếu gói Regular', null, 'Gói', 15000, 120, 1],
            [26, 'Hủ tiếu gói Special', null, 'Gói', 20000, 80, 1],
            [27, 'Hủ tiếu hộp Regular', null, 'Hộp', 25000, 100, 1],
            [28, 'Bún xào Regular', null, 'Phần', 25000, 90, 1],
            [28, 'Bún xào Special', null, 'Phần', 30000, 70, 1],
            [29, 'Cơm chiên dương châu Regular', null, 'Phần', 25000, 80, 1],
            [29, 'Cơm chiên dương châu Special', null, 'Phần', 30000, 60, 1],
            [30, 'Cơm sườn Regular', null, 'Phần', 28000, 70, 1],
            [30, 'Cơm sườn Large', null, 'Phần', 35000, 50, 1],
        ];

        foreach ($variables as $variable) {
            Variable::create([
                'product_id' => $variable[0],
                'name' => $variable[1],
                'image' => $variable[2],
                'unit' => $variable[3],
                'price' => $variable[4],
                'quantity' => $variable[5],
                'status' => $variable[6],
            ]);
        }
    }
}
