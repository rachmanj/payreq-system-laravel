<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            'department_name' => 'Corporate Secretary',
            'akronim' => 'CSEC',
        ]);

        DB::table('departments')->insert([
            'department_name' => 'Accounting',
            'akronim' => 'ACC',
        ]);

        DB::table('departments')->insert([
            'department_name' => 'Information Technology',
            'akronim' => 'IT',
        ]);

        DB::table('departments')->insert([
            'department_name' => 'Human Capital and Services',
            'akronim' => 'HCS',
        ]);

        DB::table('departments')->insert([
            'department_name' => 'Design and Constructions',
            'akronim' => 'DNC',
        ]);

        DB::table('departments')->insert([
            'department_name' => 'Plant',
            'akronim' => 'PLT',
        ]);

        DB::table('departments')->insert([
            'department_name' => 'Logistic',
            'akronim' => 'LOG',
        ]);

        DB::table('departments')->insert([
            'department_name' => 'Research and Development',
            'akronim' => 'RND',
        ]);

        DB::table('departments')->insert([
            'department_name' => 'Relationship and Coordination',
            'akronim' => 'RNC',
        ]);
    }
}
