<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;
use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use Illuminate\Http\Request;
use App\ManagerPermission;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the employee.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $editableEmployee = null;
        $companyList = Company::pluck('name', 'id');

        $employeeQuery = Employee::where(function ($query) {
            $searchQuery = request('q');
            $query->where('first_name', 'like', '%'.$searchQuery.'%');
            $query->orWhere('last_name', 'like', '%'.$searchQuery.'%');
        });

        if ($companyId = request('company_id')) {
            $employeeQuery->where('company_id', $companyId);
        }

        $employees = $employeeQuery->with('company')->paginate();

        if (in_array(request('action'), ['edit', 'delete']) && request('id') != null) {
            $editableEmployee = Employee::find(request('id'));
        }

        return view('employees.index', compact('employees', 'editableEmployee', 'companyList'));
    }

    /**
     * Store a newly created employee in storage.
     *
     * @param \App\Http\Requests\EmployeeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeCreateRequest $request)
    {

      $user = auth()->user();
      $has_permission = ManagerPermission::where('user_id', $user)->where("company_id", $request["company_id"])->first();
      if ($user->role == "manager" && !$has_permission) {
        return redirect()->back()->withErrors(['You need permission to edit this Employee']);
      }

        $newEmployee = $request->validated();
        $newEmployee['creator_id'] = auth()->id();

        Employee::create($newEmployee);

        return redirect()->route('employees.index');
    }

    /**
     * Update the specified employee in storage.
     *
     * @param \App\Http\Requests\EmployeeUpdateRequest $request
     * @param \App\Employee                            $employee
     *
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
      // check if user can update employee
    $user = auth()->user();
      if (!$user->can_manage_employee($employee)) {
        return redirect()->back()->withErrors(['You do not have access to this employee']);
      }

        $employeeData = $request->validated();
        $employee->update($employeeData);

        $routeParam = request()->only('page', 'q');

        return redirect()->route('employees.index', $routeParam);
    }

    /**
     * Remove the specified employee from storage.
     *
     * @param \App\Employee $employee
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $this->authorize('delete', $employee);

        $this->validate(request(), [
            'employee_id' => 'required',
        ]);

        $routeParam = request()->only('page', 'q');

        if (request('employee_id') == $employee->id && $employee->delete()) {
            return redirect()->route('employees.index', $routeParam);
        }

        return back();
    }
}
