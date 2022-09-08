<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search ?? '';
        $except =  Auth::user()->employee() ? Auth::user()->employee->id : 0;
        $employees = Employee::query()
            ->withTrashed()->select(['id', 'employee_id', 'last_name', 'first_name', 'middle_name', 'position'])
            ->whereNot('id', $except)
            ->when($search, function ($query) use ($search) {
                $trimmed = '%' . trim($search) . '%';
                $query->where('employee_id', 'LIKE', $trimmed)
                    ->orWhere('last_name', 'LIKE', $trimmed)
                    ->orWhere('first_name', 'LIKE', $trimmed)
                    ->orWhere('middle_name', 'LIKE', $trimmed);
            })
            ->paginate()->withQueryString();
        return Inertia::render('Admin/Employee/List', [
            'employees' => $employees,
            'filters' => ['search' => $search]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($employee)
    {
        $read = Employee::withTrashed()->with('user')->findOrFail($employee);
        return Inertia::render('Admin/Employee/Read', [
            'employee' => $read,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($employee)
    {
        $read = Employee::withTrashed()->find($employee);
        $user = $read->user();

        $read->forceDelete();
        $user->forceDelete();

        return redirect()->route('employees');
    }
}
