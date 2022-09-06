<?php

namespace App\Traits;

use App\Models\Employee;
use Carbon\Carbon;

trait EmployeeId
{
    public static function bootEmployeeId()
    {
        // updating student number when model is created
        static::creating(function (Employee $employee) {
            $currentDate = Carbon::now()->format('Y-m-d');
            $prefix =  str_replace('-', '', $currentDate);
            $suffix = '000001';

            $max_employee_id = Employee::withTrashed()->max('employee_id');

            if ($max_employee_id) {
                $split_number = preg_split('/-/', $max_employee_id);
                $suffix = end($split_number);

                //add 1 to last employee id
                $new_number = intval($suffix) + 1;
                $suffix = sprintf("%06d", $new_number);
            }

            $employee->employee_id = $prefix . '-' . $suffix;
        });
    }
}
