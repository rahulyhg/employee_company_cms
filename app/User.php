<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Employee;
use App\Company;
use App\ManagerPermission;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    // Returns true or false if the user has access to a certain employee
    public function can_manage_employee(Employee $employee){
      if ($this->role == "admin") {
        return true;
      }
      // get company
      $company = Company::where("id", $employee->company_id)->firstOrFail();
      // get permission
      $permission = ManagerPermission::where("company_id", $company->id)->where("user_id", $this->id)->first();
      // if permission return yes, else no
      if ($permission) {
        return true;
      } else {
        return false;
      }
  }



  // Returns true or false if the user has access to a certain company
  public function can_manage_company(Company $company){

    if ($this->role == "admin") {
      return true;
    }
    // get permission
    $permission = ManagerPermission::where("company_id", $company->id)->where("user_id", $this->id)->first();
    // if permission return yes, else no
    if ($permission) {
      return true;
    } else {
      return false;
    }

}





}
