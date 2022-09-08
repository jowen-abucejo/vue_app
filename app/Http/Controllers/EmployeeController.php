<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
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
        return Inertia::render('Admin/Employee/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'last_name' => 'required|regex:/^[a-zA-zÑñ ]*$/',
            'first_name' => 'required|regex:/^[a-zA-zÑñ ]*$/',
            'middle_name' => 'required|regex:/^[a-zA-zÑñ ]*$/',
            'gender' => 'required',
            'birth_date' => 'required',
            'email' => 'required|email|unique:employees,email',
            'position' => 'required',
            'salary' => 'required|min:0.00',
            'profile_pic' => [
                'required',
                File::types(['jpg', 'jpeg', 'png'])
                    ->max(12 * 1024),
            ],
        ]);

        $birth_date = new DateTime($request->input('birth_date'));
        $file = $request->hasFile('profile_pic') ? $request->file('profile_pic')->store('public/profile_pics') : '';
        $new_employee = Employee::create([
            'first_name' => trim($request->input('first_name')),
            'middle_name' => trim($request->input('middle_name')),
            'last_name' =>  trim($request->input('last_name')),
            'birth_date' => $birth_date->format('Y-m-d'),
            'gender' => $request->input('gender'),
            'email' => $request->input('email'),
            'position' => $request->input('position'),
            'salary' => $request->input('salary'),
            'profile_pic' => $file
        ]);

        // return Inertia::render('Admin/Employee/Read', [
        //     'employee' => $new_employee,
        // ]);
        return redirect()->route('employees.show', [$new_employee->id]);
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
     * @param  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($employee)
    {
        $read = $employee ? Employee::withTrashed()->with('user')->findOrFail($employee) : null;
        return Inertia::render('Admin/Employee/Edit', [
            'employee' => $read,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $employee)
    {
        $read = $employee ? Employee::withTrashed()->with('user')->findOrFail($employee) : null;
        $this->validate($request, [
            'last_name' => 'required|regex:/^[a-zA-zÑñ ]*$/',
            'first_name' => 'required|regex:/^[a-zA-zÑñ ]*$/',
            'middle_name' => 'required|regex:/^[a-zA-zÑñ ]*$/',
            'gender' => 'required',
            'birth_date' => 'required',
            'email' => 'required|email|unique:employees,email,' . $read->id,
            'position' => 'required',
            'salary' => 'required|min:0.00',
        ]);
        $birth_date = new DateTime($request->input('birth_date'));
        $file = $request->hasFile('profile_pic') ? $request->file('profile_pic')->store('public/profile_pics') : $read->profile_pic;
        $read->update([
            'first_name' => trim($request->input('first_name')),
            'middle_name' => trim($request->input('middle_name')),
            'last_name' =>  trim($request->input('last_name')),
            'birth_date' => $birth_date,
            'gender' => $request->input('gender'),
            'email' => $request->input('email'),
            'position' => $request->input('position'),
            'salary' => $request->input('salary'),
            'profile_pic' => $file
        ]);

        // return Inertia::render('Admin/Employee/Read', [
        //     'employee' => $read,
        // ]);
        return redirect()->route('employees.show', [$read->id]);
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

        Storage::delete($read->profile_pic);
        $read->forceDelete();
        $user->forceDelete();

        return redirect()->route('employees');
    }
}
