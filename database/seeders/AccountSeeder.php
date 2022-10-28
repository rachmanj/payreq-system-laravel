<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->insert([
            'name' => 'PC HO',
            'account_no' => '111111',
        ]);

        DB::table('accounts')->insert([
            'name' => 'PC DnC',
            'account_no' => '111115',
        ]);
    }
}
