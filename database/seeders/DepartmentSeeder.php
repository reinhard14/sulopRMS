<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'code' => '001',
            'name' => 'DSWD',
            'description' => 'Department of Social Welfare and Development',
        ]);
        Department::create([
            'code' => '002',
            'name' => 'OED',
            'description' => 'Office of Engineering Department',
        ]);
    }
}
