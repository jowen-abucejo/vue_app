<?php

namespace Database\Seeders;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = [
            [
                'user_id' => 1,
                'first_name' => 'Juan',
                'middle_name' => '',
                'last_name' => 'de la Cruz',
                'birth_date' => Carbon::now()->subYears(34)->subMonths(4)->subDays(8)->format('Y-m-d'),
                'gender' => 'M',
                'position' => 'CEO',
                'salary' => 400000.00
            ],
            [
                'first_name' => 'Maria',
                'middle_name' => 'Ariel',
                'last_name' => 'Mercado',
                'birth_date' => Carbon::now()->subYears(30)->subMonths(2)->format('Y-m-d'),
                'gender' => 'F',
                'position' => 'Senior Developer',
                'salary' => 100000.00
            ],
            [
                'first_name' => 'Peter',
                'middle_name' => 'Cruz',
                'last_name' => 'Lastimosa',
                'birth_date' => Carbon::now()->subYears(25)->subDays(27)->format('Y-m-d'),
                'gender' => 'M',
                'position' => 'Junior Software Tester',
                'salary' => 30000.00
            ]
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }
    }
}
