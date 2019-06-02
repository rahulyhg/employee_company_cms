<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Employee;
use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\ManagerPermission;
use App\User;

class ManagerPermissionController extends Controller
{


  public function create(Request $request, $id){

    $company = Company::where("id",$id )->firstOrFail();
    $managers = User::where("role", "manager")->get();
    return view('mp.create', ["company" => $company, "managers" =>$managers]);
  }


  public function store(Request $request){

    $data = $request->all();
    // make sure user is admin
    $user = auth()->user();
    if ($user->role == "manager") {
      return redirect()->back()->withErrors(['Managers cannot add permissions']);
    }
    $mp = new ManagerPermission;
    $mp->user_id = $data["manager_id"];
    $mp->company_id = $data["company_id"];
    $mp->save();
      return redirect()->back()->withErrors(['Successfully Added Manager']);
  }


  public function destroy(Request $request){

    $data = $request->all();
    $user = auth()->user();
    if ($user->role == "manager") {
      return redirect()->back()->withErrors(['Managers cannot delete permissions']);
    }
    $company_id = $data["company"];
    $mp = ManagerPermission::where("user_id", $data["manager"] )->where("company_id",$company_id )->first();
    $mp->delete();
    return redirect()->back();

  }


}
