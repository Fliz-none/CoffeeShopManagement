<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['Xem danh sách tài khoản', 'web', 'Tài khoản', '1'],
            ['Xem chi tiết tài khoản', 'web', 'Tài khoản', '1'],
            ['Tạo tài khoản', 'web', 'Tài khoản', '1'],
            ['Cập nhật tài khoản', 'web', 'Tài khoản', '1'],
            ['Xóa tài khoản', 'web', 'Tài khoản', '1'],
            ['Xóa hàng loạt tài khoản', 'web', 'Tài khoản', '1'],
            ['Xem danh sách vai trò', 'web', 'Vai trò', '1'],
            ['Xem chi tiết vai trò', 'web', 'Vai trò', '1'],
            ['Tạo vai trò', 'web', 'Vai trò', '1'],
            ['Cập nhật vai trò', 'web', 'Vai trò', '1'],
            ['Xóa vai trò', 'web', 'Vai trò', '1'],
            ['Xem danh sách danh mục', 'web', 'Danh mục', 'has_shop'],
            ['Tạo danh mục', 'web', 'Danh mục', 'has_shop'],
            ['Cập nhật danh mục', 'web', 'Danh mục', 'has_shop'],
            ['Xóa danh mục', 'web', 'Danh mục', 'has_shop'],
            ['Xóa hàng loạt danh mục', 'web', 'Danh mục', 'has_shop'],
            ['Xem danh sách sản phẩm', 'web', 'Sản phẩm', 'has_shop'],
            ['Xem chi tiết sản phẩm', 'web', 'Sản phẩm', 'has_shop'],
            ['Tạo sản phẩm', 'web', 'Sản phẩm', 'has_shop'],
            ['Cập nhật sản phẩm', 'web', 'Sản phẩm', 'has_shop'],
            ['Xóa sản phẩm', 'web', 'Sản phẩm', 'has_shop'],
            ['Xóa hàng loạt sản phẩm', 'web', 'Sản phẩm', 'has_shop'],
            ['Xem danh sách bàn', 'web', 'Bàn', 'has_shop'],
            ['Tạo bàn', 'web', 'Bàn', 'has_shop'],
            ['Cập nhật bàn', 'web', 'Bàn', 'has_shop'],
            ['Đặt bàn', 'web', 'Bàn', 'has_shop'],
            ['Xóa bàn', 'web', 'Bàn', 'has_shop'],
            ['Xóa hàng loạt bàn', 'web', 'Bàn', 'has_shop'],
            ['Xem danh sách phòng', 'web', 'Phòng', 'has_shop'],
            ['Tạo phòng', 'web', 'Phòng', 'has_shop'],
            ['Cập nhật phòng', 'web', 'Phòng', 'has_shop'],
            ['Đặt phòng', 'web', 'Phòng', 'has_shop'],
            ['Xóa phòng', 'web', 'Phòng', 'has_shop'],
            ['Xóa hàng loạt phòng', 'web', 'Phòng', 'has_shop'],
            ['Xem danh sách đơn hàng', 'web', 'Đơn hàng', 'has_shop'],
            ['Xem chi tiết đơn hàng', 'web', 'Đơn hàng', 'has_shop'],
            ['Tạo đơn hàng', 'web', 'Đơn hàng', 'has_shop'],
            ['Cập nhật đơn hàng', 'web', 'Đơn hàng', 'has_shop'],
            ['Xóa đơn hàng', 'web', 'Đơn hàng', 'has_shop'],
            ['Xóa hàng loạt đơn hàng', 'web', 'Đơn hàng', 'has_shop'],
            ['Xem danh sách giao dịch', 'web', 'Giao dịch', 'has_shop'],
            ['Xem chi tiết giao dịch', 'web', 'Giao dịch', 'has_shop'],
            ['Tạo giao dịch', 'web', 'Giao dịch', 'has_shop'],
            ['Cập nhật giao dịch', 'web', 'Giao dịch', 'has_shop'],
            ['Xóa giao dịch', 'web', 'Giao dịch', 'has_shop'],
            ['Xem danh sách hình ảnh', 'web', 'Hình ảnh', '1'],
            ['Xem chi tiết hình ảnh', 'web', 'Hình ảnh', '1'],
            ['Tạo hình ảnh', 'web', 'Hình ảnh', '1'],
            ['Cập nhật hình ảnh', 'web', 'Hình ảnh', '1'],
            ['Xóa hình ảnh', 'web', 'Hình ảnh', '1'],
            ['Xóa hàng loạt hình ảnh', 'web', 'Hình ảnh', '1'],
            ['Xem danh sách lịch làm việc', 'web', 'Lịch làm việc', 'has_attendance'],
            ['Tạo lịch làm việc', 'web', 'Lịch làm việc', 'has_attendance'],
            ['Cập nhật lịch làm việc', 'web', 'Lịch làm việc', 'has_attendance'],
            ['Xóa lịch làm việc', 'web', 'Lịch làm việc', 'has_attendance'],
            ['Xem danh sách chấm công', 'web', 'Chấm công', 'has_attendance'],
            ['Tạo chấm công', 'web', 'Chấm công', 'has_attendance'],
            ['Xem chi tiết chấm công', 'web', 'Chấm công', 'has_attendance'],
            ['Xóa chấm công', 'web', 'Chấm công', 'has_attendance'],
            ['Truy cập trang quản trị', 'web', 'Trang quản trị', '1'],
            ['Truy cập trang thiết lập', 'web', 'Trang thiết lập', '1'],
            ['Truy cập trang bảng tin', 'web', 'Trang bảng tin', '1'],
            ['Truy cập trang nhật ký hệ thống', 'web', 'Trang nhật ký hệ thống', '1'],
            ['Truy cập trang danh sách lỗi', 'web', 'Trang danh sách lỗi', '1'],
            ['Xem danh sách công ty', 'web', 'Công ty', '0'],
            ['Tạo công ty', 'web', 'Công ty', '0'],
            ['Cập nhật công ty', 'web', 'Công ty', '0'],
            ['Xem chi tiết công ty', 'web', 'Công ty', '0'],
            ['Khóa công ty', 'web', 'Công ty', '0'],
        ];
        for ($i = 0; $i < count($permissions); $i++) {
            Permission::create([
                'id' => $i + 1,
                'name' => $permissions[$i][0],
                'guard_name' => $permissions[$i][1],
                'section' => $permissions[$i][2],
                'scope' => $permissions[$i][3],
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
