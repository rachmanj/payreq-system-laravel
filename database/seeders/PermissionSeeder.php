<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'approve',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'outgoing',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'realization',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'verify',
            'guard_name' => 'web',
        ]);

        DB::table('permissions')->insert([
            'name' => 'akses_rab',
            'guard_name' => 'web',
        ]);
    }
}
