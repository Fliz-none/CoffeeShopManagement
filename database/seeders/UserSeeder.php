<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [1, 'Lê Hoàng Thắng', '0358351262', 'thangle2003ss@gmail.com', 0, 'Admin@123'],
            [2, 'Lê Hải Đăng', '0942852755', 'lhd4388@gmail.com', 0 , 'haidang1210'],
            [3, 'Cao Bùi Gia Huy', '0753216984', 'caohuy.cantho@gmail.com', 0, 'Admin@123'],
            [4, 'Minh Đăng', '0931256874', 'minhdang@gmail.com', 0, 'Admin@123'],
            [5, 'Huế Minh', '0395146278', 'phamthihueminh2003@gmail.com', 1, 'Admin@123'],
            [6, 'Trương Như Ý', '0395146278', 'ynhutruong2712@gmail.com', 1, 'Admin@123'],
        ];

        foreach ($users as $user) {
            User::create([
                'id' => $user[0],
                'name' => $user[1],
                'phone' => $user[2],
                'email' => $user[3],
                'gender' => $user[4],
                'password' => Hash::make($user[5]),
                'main_branch' => 1,
                'status' => 1,
                'company_id' => 1,
            ]);
        }

        // DB::statement("
        // INSERT INTO `branch_user` (`id`, `user_id`, `branch_id`) VALUES
        // (12, 519, 1),
        // (25, 3939, 1),
        // (29, 3606, 1),
        // (30, 832, 2),
    }
}
