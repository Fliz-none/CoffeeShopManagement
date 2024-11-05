<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 3; $i++) {
            for ($j = 1; $j < 16; $j++) {
                Table::create(['name' => 'Bàn ' . $j . ' lầu ' . $i, 'company_id' => 1]);
            }
        }
    }
}
