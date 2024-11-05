<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CompanySeeder::class,
            BranchSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,

            RoleSeeder::class,
            CatalogueSeeder::class,
            ProductSeeder::class,
            SettingsSeeder::class,
            TableSeeder::class,
        ]);
    }
}
