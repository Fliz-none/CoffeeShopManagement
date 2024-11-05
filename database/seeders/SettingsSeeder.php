<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'id' => 1,
            'key' => 'ip',
            'value' => '14.161.197.139',
            'company_id' => 1
        ]);
        DB::table('settings')->insert([
            'id' => 2,
            'key' => 'logo',
            'value' => 'logo_horizon.png',
            'company_id' => 1
        ]);
        DB::table('settings')->insert([
            'id' => 3,
            'key' => 'favicon',
            'value' => 'favicon.png',
            'company_id' => 1
        ]);
        DB::table('settings')->insert([
            'id' => 4,
            'key' => 'store_name',
            'value' => 'Key Digital Coffee',
            'company_id' => 1
        ]);
        DB::table('settings')->insert([
            'id' => 5,
            'key' => 'store_address',
            'value' => '298 Nguyễn Văn Linh, P. An Khánh, Q. Ninh Kiều, TP. Cần Thơ',
            'company_id' => 1
        ]);
        DB::table('settings')->insert([
            'id' => 6,
            'key' => 'store_shortname',
            'value' => 'Key Digital',
            'company_id' => 1
        ]);
        DB::table('settings')->insert([
            'id' => 7,
            'key' => 'store_phone',
            'value' => '0939403090',
            'company_id' => 1
        ]);
        DB::table('settings')->insert([
            'id' => 8,
            'key' => 'bank_id',
            'value' => '970436',
            'company_id' => 1
        ]);
        DB::table('settings')->insert([
            'id' => 9,
            'key' => 'bank_name',
            'value' => 'NGÂN HÀNG TMCP NGOẠI THƯƠNG VIỆT NAM (VIETCOMBANK)',
            'company_id' => 1
        ]);
        DB::table('settings')->insert([
            'id' => 10,
            'key' => 'bank_account',
            'value' => 'Võ Minh Quân',
            'company_id' => 1
        ]);
        DB::table('settings')->insert([
            'id' => 11,
            'key' => 'bank_number',
            'value' => '0111000192555',
            'company_id' => 1
        ]);
        DB::table('settings')->insert([
            'id' => 12,
            'key' => 'standard_attendance_time',
            'value' => '4',
            'company_id' => 1
        ]);

        DB::table('settings')->insert([
            'id' => 13,
            'key' => 'max_attendance_time',
            'value' => '12',
            'company_id' => 1
        ]);

        DB::table('settings')->insert([
            'id' => 14,
            'key' => 'ip_attendance_required',
            'value' => '',
            'company_id' => 1
        ]);

        DB::table('settings')->insert([
            'id' => 15,
            'key' => 'image_attendance_required',
            'value' => '1',
            'company_id' => 1
        ]);

        DB::table('settings')->insert([
            'id' => 16,
            'key' => 'attendance_by_standard_attendance_time',
            'value' => '1',
            'company_id' => 1
        ]);

        DB::table('settings')->insert([
            'id' => 17,
            'key' => 'pass_wifi',
            'value' => 'Muamaybandat',
            'company_id' => 1
        ]);

        DB::table('settings')->insert([
            'id' => 18,
            'key' => 'store_slogan',
            'value' => 'cảm ơn quý khách!',
            'company_id' => 1
        ]);

        DB::table('settings')->insert([
            'id' => 19,
            'key' => 'bill_template',
            'value' => '3',
            'company_id' => 1
        ]);

        DB::table('settings')->insert([
            'id' => 20,
            'key' => 'mail_from_address',
            'value' => 'lhd4388@gmail.com',
            'company_id' => 1
        ]);

        DB::table('settings')->insert([
            'id' => 21,
            'key' => 'mail_username',
            'value' => 'lhd4388@gmail.com',
            'company_id' => 1
        ]);

        DB::table('settings')->insert([
            'id' => 22,
            'key' => 'mail_password',
            'value' => 'lhd4388@gmail.com',
            'company_id' => 1
        ]);

        DB::table('settings')->insert([
            'id' => 23,
            'key' => 'mail_encryption',
            'value' => 'TLS',
            'company_id' => 1
        ]);

        DB::table('settings')->insert([
            'id' => 24,
            'key' => 'mail_mailer',
            'value' => 'smtp',
            'company_id' => 1
        ]);
    }
}
