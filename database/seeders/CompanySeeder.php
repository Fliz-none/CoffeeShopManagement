<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            [
                'id' => 1,
                'name' => 'PASSED Nguyễn Văn Cừ ND',
                'deadline' => '2025-12-31',
                'domain' => '',
                'contract_total' => '1000000',
                'has_shop' => 1,
                'has_revenue' => 1,
                'has_attendance' => 1,
                'has_account' => 1,
                'has_log' => 1,
                'address' => 'Địa chỉ 123 NVC ND',
                'phone' => '0123456789',
                'email' => 'contact@us.com',
                'tax_id' => '123456789',
                'status' => 1,
                'note' => 'Ghi chú ??',
                'created_at' => '2024-10-04 07:43:11.000000',
                'updated_at' => '2024-10-04 07:43:11.000000'
            ],
            [
                'id' => 2,
                'name' => 'Thành Viên Mới',
                'deadline' => '2025-10-31',
                'contract_total' => '2700000',
                'has_shop' => 1,
                'has_revenue' => 1,
                'has_attendance' => 1,
                'has_account' => 1,
                'has_log' => 1,
                'address' => 'Đ. Mậu Thân/142 Đ. Nguyễn Việt Hồng, An Nghiệp, Ninh Kiều, Cần Thơ',
                'domain' => 'thanhvienmoi.com',
                'phone' => '0123456789',
                'email' => 'thanhvienmoi@gmail.com',
                'tax_id' => null,
                'status' => 1,
                'note' => null,
                'created_at' => '2024-10-04 07:43:11.000000',
                'updated_at' => '2024-10-04 07:43:11.000000'
            ],
        ];

        DB::table('companies')->insert($companies);
    }
}
