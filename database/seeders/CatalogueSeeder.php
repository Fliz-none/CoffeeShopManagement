<?php

namespace Database\Seeders;

use App\Models\Catalogue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Random;

class CatalogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $catalogues = [
            [1, 'tieu-dung', 'Tiêu dùng', NULL, 1, NULL, 1, 'Các sản phẩm mang đặc tính tiêu hao, cạn dần theo thời gian sử dụng. VD: Thức ăn, cát, dầu gội, nước hoa, xà bông, kem v.v...', NULL, '2024-06-10 14:09:32', '2024-07-23 15:12:34'],
            [2, 'hang-hoa', 'Hàng hóa', NULL, 1, NULL, 1, 'Các sản phẩm sử dụng kinh doanh buôn bán', NULL, '2024-06-10 14:09:32', '2024-07-23 15:12:34'],
            [3, 'thuc-an', 'Thức ăn', NULL, 1, NULL, 1, 'Các sản phẩm sử dụng kinh doanh buôn bán', NULL, '2024-06-10 14:09:32', '2024-07-23 15:12:34'],
            [4, 'nuoc-uong', 'Nước uống', NULL, 1, NULL, 1, 'Các sản phẩm sử dụng kinh doanh buôn bán', NULL, '2024-06-10 14:09:32', '2024-07-23 15:12:34'],
            [5, 'thuc-an-nhanh', 'Thức ăn nhanh', NULL, 1, 3, 1, 'Các sản phẩm sử dụng kinh doanh buôn bán', NULL, '2024-06-10 14:09:32', '2024-07-23 15:12:34'],
        ];
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach ($catalogues as $key => $catalogue) {
            Catalogue::create([
                'id' => $catalogue[0],
                'slug' => $catalogue[1],
                'name' => $catalogue[2],
                'avatar' => $catalogue[3],
                'sort' => $catalogue[4],
                'parent_id' => $catalogue[5],
                'status' => $catalogue[6],
                'note' => $catalogue[7],
                'deleted_at' => $catalogue[8],
                'created_at' => $catalogue[9],
                'updated_at' => $catalogue[10],
                'company_id' => 1,
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
