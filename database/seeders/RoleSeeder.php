<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin_role = Role::create(['id' => 1, 'name' => 'Admin', 'guard_name' => 'web', 'company_id' => 1]);
        $permissions = Permission::all();
        $admin_role->syncPermissions($permissions);

        $role = Role::create(['name' => 'Chủ cửa hàng', 'guard_name' => 'web', 'company_id' => 1]);
        $permissions = Permission::select('*')->whereNotIn('section', ['Trang danh sách lỗi', 'Công ty'])->get();
        $role->syncPermissions($permissions);

        $role = Role::create(['name' => 'Quản lý', 'guard_name' => 'web', 'company_id' => 1]);
        $permissions = Permission::select('*')->whereNotIn('section', ['Trang danh sách lỗi', 'Công ty', 'Trang thiết lập', 'Trang bảng tin', 'Vai trò'])->get();
        $role->syncPermissions($permissions);

        $role = Role::create(['name' => 'Nhân viên', 'guard_name' => 'web', 'company_id' => 1]);
        $permissions = Permission::select('*')->whereIn('section', ['Đơn hàng', 'Giao dịch', 'Bàn', 'Phòng', 'Khách hàng', 'Hình ảnh'])->get();
        $role->syncPermissions($permissions);

        $users = User::all();
        foreach ($users as $user) {
            $user->assignRole($admin_role);
        }

    }
}
