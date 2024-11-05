<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branches')->insert([
            [
                'company_id' => 1,
                'name' => 'Công ty TNHH PASSED',
                'phone' => '0987654321',
                'address' => 'Ninh Kiều, Cần Thơ',
                'note' => '',
                'status' => 1,
                'deleted_at' => null,
                'created_at' => Carbon::create('2024', '06', '10', '14', '09', '32'),
                'updated_at' => Carbon::create('2024', '07', '05', '17', '37', '58'),
            ],
            [
                'company_id' => 2,
                'name' => 'Công ty TNHH MTV Thành Viên Mới',
                'phone' => '0123456789',
                'address' => 'Đ. Mậu Thân/142 Đ. Nguyễn Việt Hồng, An Nghiệp, Ninh Kiều, Cần Thơ',
                'note' => null,
                'status' => 1,
                'deleted_at' => null,
                'created_at' => Carbon::create('2024', '06', '10', '14', '09', '32'),
                'updated_at' => Carbon::create('2024', '06', '10', '14', '09', '32'),
            ],
        ]);
    }
}
